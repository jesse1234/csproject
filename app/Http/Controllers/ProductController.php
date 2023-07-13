<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Product;
use App\Models\Order;

class ProductController extends Controller
{
    public function importProducts()
    {
        $total_product= Product::all()->count();
        $total_order= Order::all()->count();
        return view('admin.import_products',compact('total_product','total_order'));
    }

    public function uploadProducts (Request $request)
    {
        Excel::Import( new ProductsImport, $request->file);
        return redirect()->back()->with('success', 'Product Imported Successfully');
    }

    
}
