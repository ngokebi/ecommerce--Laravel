<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function Brands()
    {
        $brands = Brand::latest()->get();

        return view('admin.pages.brands', compact('brands'));
    }
}
