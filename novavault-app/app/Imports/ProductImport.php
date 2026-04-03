<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class ProductImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public function __construct(
        protected int $vendorId,
    ) {}

    public function model(array $row): Product
    {
        return new Product([
            'vendor_id' => $this->vendorId,
            'title' => $row['title'],
            'description' => $row['description'] ?? null,
            'sku' => $row['sku'] ?? null,
            'price' => $row['price'],
            'backstock_qty' => $row['stock'] ?? $row['backstock_qty'] ?? 0,
            'status' => $row['status'] ?? 'active',
            'low_stock_threshold' => $row['low_stock_threshold'] ?? 5,
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'backstock_qty' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', 'in:active,inactive'],
        ];
    }
}
