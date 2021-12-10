<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    public function Products()
    {
        $product = Products::latest()->get();

        return view('admin.pages.products.prducts', compact('product'));
    }
}
