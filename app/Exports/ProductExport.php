<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\Admin\Models\Product;

class ProductExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Product::select('id', 'name', 'description', 'price', 'quantity', 'is_active', 'category_id', 'created_at')
            ->with('category:id,name')
            ->get()
            ->map(function ($product) {
                return [
                    'ID' => $product->id,
                    'Name' => $product->name,
                    'Description' => $product->description,
                    'Price' => $product->price,
                    'Quantity' => $product->quantity,
                    'Status' => $product->is_active ? 'Active' : 'Inactive',
                    'Category' => $product->category->name ?? 'N/A',
                    'Created At' => $product->created_at->format('Y-m-d H:i:s'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Description',
            'Price',
            'Quantity',
            'Status',
            'Category',
            'Created At'
        ];
    }
}