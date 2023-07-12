<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'title' => $row['title'],
            'description' => $row['description'],
            'stock' => $row['stock'],
            'category_id' => $row['category_id'],
            'image' => $row['image'],
            'image_3d' => $row['image_3d'],
            'price' => $row['price'],
            'discount_price' => $row['discount_price'],
            'vendor_id' => $row['vendor_id'],
        ]);
    }
}
