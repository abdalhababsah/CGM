<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsDiscountImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use Importable;
    use RemembersRowNumber;

    protected $errors = [];

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param int $row
     * @param string $field
     * @param string $message
     */
    public function addError(int $row, string $field, string $message)
    {
        $this->errors[] = [
            'row' => $row,
            'field' => $field,
            'message' => $message,
        ];
    }
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'required|exists:products,id',
            'discount' => 'nullable|numeric|min:0',
        ];
    }
    /**
    * @param array $row
    *
    */
    public function model(array $row)
    {
        $product = Product::find($row['id']);
        if ($product) {
            $product->update(['discount' => $row['discount']]);
        }
        return $product;
    }

    /**
     * @param \Throwable $error
     */
    public function onError(\Throwable $error)
    {
        $this->addError($this->getRowNumber(), 'general', $error->getMessage());
    }
}
