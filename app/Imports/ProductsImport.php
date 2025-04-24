<?php

namespace App\Imports;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
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
class ProductsImport implements ToModel, WithHeadingRow, SkipsOnError, WithValidation, SkipsOnFailure, WithChunkReading, WithBatchInserts, ShouldQueue
{
    use RemembersRowNumber;
    use Importable;
    use SkipsFailures;

    protected $errors = [];

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
        $this->rowNumber = $this->getRowNumber() ?? 1;

        // Generate SKU if not provided
        $sku = $row['sku'] ?? strtoupper(Str::random(10));
        $sku = isset($row['sku']) && !empty($row['sku']) ? $row['sku'] : strtoupper(Str::random(10));

        // Create the product
        $product = Product::create(
            [
                'sku' => $sku, // Use the generated or provided SKU
                'name_en' => $row['name_en'],
                'name_ar' => $row['name_ar'],
                'name_he' => $row['name_he'],
                'category_id' => $row['category_id'],
                'brand_id' => $row['brand_id'],
                'price' => $row['price'],
                'discount' => $row['discount'] ?? 0,
                'quantity' => $row['quantity'] ?? 0,
                'is_active' => $row['is_active'] ?? 1,
                'description_en' => $row['description_en'] ?? null,
                'description_ar' => $row['description_ar'] ?? null,
                'description_he' => $row['description_he'] ?? null,
                'created_at' => isset($row['old']) && $row['old'] ? Carbon::now()->subMonth() : now(),
            ]
        );

        // Handle primary image
        if (!empty($row['primary_image'])) {
            try {
                try {
                    $this->storeImage($row['primary_image'], $product, true);
                } catch (\Exception $e) {
                    $this->addError(row: $this->rowNumber, field: 'primary_image', message: 'Failed to store primary image: ' . $e->getMessage());
                    Log::error('Failed to store primary image for product SKU ' . $product->sku . ': ' . $e->getMessage());
                }
            } catch (\Exception $e) {
                $this->addError(row: $this->rowNumber, field: 'primary_image', message: 'Failed to store primary image: ' . $e->getMessage());
                Log::error('Failed to store primary image for product SKU ' . $product->sku . ': ' . $e->getMessage());
            }
        }

        // Handle additional images
        $imageColumns = array_filter(['image_1', 'image_2', 'image_3'], function($imageColumn) use ($row) {
            return !empty($row[$imageColumn]);
        });
        foreach ($imageColumns as $imageColumn) {
            try {
                $this->storeImage($row[$imageColumn], $product, false);
            } catch (\Exception $e) {
                $this->addError(row: $this->rowNumber, field: $imageColumn, message: 'Failed to store image: ' . $e->getMessage());
            }
        }

        return $product;
    }
    /**
     * Define the validation rules for the imported product data.
     *
     * @return array
     *
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
            'primary_image' => 'nullable|url', // Validate primary_image as a valid URL
        ];
    }

    protected function addError(int $row, string $field, string $message)
    {
        $this->errors[] = compact('row', 'field', 'message');
    }
    protected function storeImage(string $imageUrl, Product $product, bool $isPrimary)
    {
        // Validate URL
        if (!filter_var($imageUrl, FILTER_VALIDATE_URL)) {
            $this->addError($this->rowNumber, 'image_url', 'Invalid image URL');
            return;
        }

        try {
            // Fetch the image from the URL
            try {
                $imageContents = file_get_contents($imageUrl);
                if ($imageContents === false) {
                    Log::error('Failed to fetch image from URL: ' . $imageUrl);
                    $this->addError($this->rowNumber, 'image', 'Failed to fetch image from URL');
                    return;
                }

                // Validate MIME type of the fetched content
                $finfo = new \finfo(FILEINFO_MIME_TYPE);
                $mimeType = $finfo->buffer($imageContents);
                if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])) {
                    Log::error("Invalid MIME type detected: {$mimeType} for URL: {$imageUrl}");
                    $this->addError($this->rowNumber, 'image', "Invalid MIME type detected: {$mimeType}");
                    return;
                }
            } catch (\Exception $e) {
                Log::error('Failed to fetch image from URL: ' . $imageUrl . '. Error: ' . $e->getMessage());
                $this->addError($this->rowNumber, 'image', 'Failed to fetch image from URL: ' . $imageUrl);
                return;
            }

            // Get the image extension from the URL or fetch it from headers if missing
            $extension = pathinfo(parse_url($imageUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
            if (empty($extension) || !in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp'])) {
                $finfo = new \finfo(FILEINFO_MIME_TYPE);
                $mimeType = $finfo->buffer($imageContents);
                $mimeToExt = [
                    'image/jpeg' => 'jpg',
                    'image/png' => 'png',
                    'image/jpg' => 'jpg',
                    'image/webp' => 'webp',
                ];
                $extension = $mimeToExt[$mimeType] ?? 'png';
                if ($mimeType) {
                    Log::info("MIME type detected: {$mimeType}. Using extension: {$extension}");
                } else {
                    Log::warning("Unable to determine MIME type for image content. Defaulting to png.");
                }
            }
            Log::info("Image extension: {$extension}");

            // Generate a unique filename
            $filename = time() . '_' . Str::random(10) . '.' . $extension;
            $path = "products/{$filename}";

            // Store the image
            if (!Storage::disk('public')->put($path, $imageContents)) {
                Log::error("Failed to store image: {$imageUrl}");
                $this->addError($this->rowNumber, 'image', 'Failed to store image');
                return;
            }

            // Create image record using the images relationship
            $product->images()->create([
                'image_url' => $path,
                'is_primary' => $isPrimary,
                'sort_order' => $isPrimary ? 0 : $product->images()->count() + 1,
            ]);
        } catch (\Exception $e) {
            $this->addError($this->rowNumber, 'general', 'Error occurred while processing image URL: ' . ($imageUrl ?? 'N/A') . '. Details: ' . $e->getMessage());
            Log::error('Failed to store image: ' . $e->getMessage());
        }
    }
    /*
     * This determines how many rows are processed at a time.
     *
     * @return int
     */
    public function chunkSize(): int
    {
        return 30;
    }
    /**
     * Define the batch size for the import process.
     * This determines the number of rows to be processed in each batch.
     *
     * @return int
     */
    public function batchSize(): int
    {
        return 30;
    }
    /**
     * Handle import errors
     */
    public function onError(Throwable $e)
    {
        $this->addError($this->rowNumber, 'general', $e->getMessage());
    }
}
