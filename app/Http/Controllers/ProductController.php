<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function importProducts()
    {
        return view('admin.import_products');
    }

    public function uploadProducts (Request $request)
    {
        Excel::Import( new ProductsImport, $request->file);
        return redirect()->back()->with('success', 'Product Imported Successfully');
    }

    
}
