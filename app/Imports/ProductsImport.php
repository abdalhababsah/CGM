<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductImage;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Throwable;

class ProductsImport implements ToModel, WithHeadingRow, SkipsOnError, WithValidation, SkipsOnFailure, WithChunkReading, ShouldQueue
{
    use Importable;
    use SkipsFailures;

    protected $errors = [];
    protected $rowNumber = 1;

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $this->rowNumber++;

        try {
            // Generate SKU if not provided
            $sku = $row['sku'] ?? strtoupper(Str::random(10));

            // Validate required fields
            if (empty($row['name_en']) || empty($row['name_ar']) || empty($row['name_he'])) {
                $this->addError($this->rowNumber, 'name', 'All name translations are required');
                return null;
            }

            if (empty($row['category_id'])) {
                $this->addError($this->rowNumber, 'category_id', 'Category ID is required');
                return null;
            }

            if (empty($row['brand_id'])) {
                $this->addError($this->rowNumber, 'brand_id', 'Brand ID is required');
                return null;
            }

            if (!isset($row['price']) || !is_numeric($row['price'])) {
                $this->addError($this->rowNumber, 'price', 'Valid price is required');
                return null;
            }

            // Create or update the product
            $product = Product::updateOrCreate(
                ['sku' => $sku], // Use the generated or provided SKU
                [
                    'name_en' => $row['name_en'],
                    'name_ar' => $row['name_ar'],
                    'name_he' => $row['name_he'],
                    'category_id' => $row['category_id'],
                    'brand_id' => $row['brand_id'],
                    'price' => $row['price'],
                    'quantity' => $row['quantity'] ?? 0,
                    'is_active' => $row['is_active'] ?? 1,
                    'description_en' => $row['description_en'] ?? null,
                    'description_ar' => $row['description_ar'] ?? null,
                    'description_he' => $row['description_he'] ?? null,
                    'created_at' => ($row['old'] ?? 1) ? Carbon::now()->subMonth() : now(),
                ]
            );

            // Handle primary image
            if (!empty($row['primary_image'])) {
                try {
                    $this->storeImage($row['primary_image'], $product, true);
                } catch (\Exception $e) {
                    $this->addError($this->rowNumber, 'primary_image', 'Failed to store primary image: ' . $e->getMessage());
                }
            }

            // Handle additional images
            foreach (['image_1', 'image_2', 'image_3'] as $imageColumn) {
                if (!empty($row[$imageColumn])) {
                    try {
                        $this->storeImage($row[$imageColumn], $product, false);
                    } catch (\Exception $e) {
                        $this->addError($this->rowNumber, $imageColumn, 'Failed to store image: ' . $e->getMessage());
                    }
                }
            }

            return $product;

        } catch (\Exception $e) {
            $this->addError($this->rowNumber, 'general', 'Error processing row: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Validation rules
     */
    public function rules(): array
    {
        return [
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
            'name_he' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id', // Added brand_id validation
            'price' => 'required|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
        ];
    }

    /**
     * Custom validation messages
     */
    public function customValidationMessages()
    {
        return [
            'brand_id.required' => 'Brand ID is required in row :row',
            'brand_id.exists' => 'Brand ID does not exist in row :row',
        ];
    }

    /**
     * Add an error message for a specific row and field
     */
    protected function addError($row, $field, $message)
    {
        $this->errors[] = [
            'row' => $row,
            'field' => $field,
            'message' => $message
        ];
    }

    /**
     * Store the image locally and associate it with the product
     */
    protected function storeImage(string $imageUrl, Product $product, bool $isPrimary)
    {
        try {
            // Validate URL
            if (!filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                throw new \Exception("Invalid image URL");
            }

            // Fetch the image from the URL
            $imageContents = @file_get_contents($imageUrl);
            if ($imageContents === false) {
                throw new \Exception("Failed to fetch image from URL");
            }

            // Generate a unique filename
            $filename = time() . '_' . Str::random(10) . '.png';
            $path = 'products/' . $filename;

            // Store the image
            if (!Storage::disk('public')->put($path, $imageContents)) {
                throw new \Exception("Failed to store image");
            }

            // Create image record
            $product->images()->create([
                'image_url' => $path,
                'is_primary' => $isPrimary,
                'sort_order' => $isPrimary ? 0 : $product->images()->count() + 1,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to store image: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Handle import errors
     */
    public function onError(Throwable $e)
    {
        $this->addError($this->rowNumber, 'general', $e->getMessage());
    }
    public function chunkSize(): int
    {
        return 30;
    }

}
