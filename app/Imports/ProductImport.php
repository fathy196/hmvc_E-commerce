<?php
namespace App\Imports;

use Modules\Admin\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;

class ProductImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new Product([
            'name'        => $row['name'],
            'description' => $row['description'] ?? null,
            'price'       => $row['price'],
            'quantity'    => $row['quantity'] ?? 0,
            'is_active'   => $row['is_active'] ?? true,
            'image'       => $row['image'] ?? null,
            'category_id' => $row['category_id'],
            // timestamps will be automatically handled
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0|max:99999999.99',
            'quantity' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    public function prepareForValidation($data)
    {
        // Convert boolean values if needed
        if (isset($data['is_active'])) {
            $data['is_active'] = filter_var($data['is_active'], FILTER_VALIDATE_BOOLEAN);
        }
        
        // Ensure price has exactly 2 decimal places
        if (isset($data['price'])) {
            $data['price'] = number_format((float)$data['price'], 2, '.', '');
        }

        return $data;
    }
}