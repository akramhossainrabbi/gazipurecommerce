<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductFormRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::get();
        return view('admin.products.list', compact('products'));
    }
    public function create() 
    {
        $brands = Brand::get();
        $categories = Category::with('children')->whereNull('category_id')->get();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function createProduct(array $params)
    {
        try {
            $collection = collect($params);

            $admin_id = session('LoggedAdmin');

            $featured = $collection->has('featured') ? 1 : 0;
            $status = $collection->has('status') ? 1 : 0;

            $merge = $collection->merge(compact('admin_id', 'status', 'featured'));

            $product = new Product($merge->all());

            $product->save();

            if ($collection->has('categories')) {
                $product->categories()->sync($params['categories']);
            }
            return $product;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    public function store(StoreProductFormRequest $request)
    {
        $params = $request->except('_token');

        $product = $this->createProduct($params);

        if (!$product) {
            return back()->with('error', 'Error occurred while creating product.');
        }
        return back()->with('success', 'Product added successfully');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);;
        $brands = Brand::get();
        $categories = Category::with('children')->whereNull('category_id')->get();

        return view('admin.products.edit', compact('categories', 'brands', 'product'));
    }

    public function updateProduct(array $params)
    {
        $product =  Product::find($params['product_id']);

        $collection = collect($params)->except('_token');

        $featured = $collection->has('featured') ? 1 : 0;
        $status = $collection->has('status') ? 1 : 0;

        $merge = $collection->merge(compact('status', 'featured'));

        $product->update($merge->all());

        if ($collection->has('categories')) {
            $product->categories()->sync($params['categories']);
        }

        return $product;
    }

    public function update(StoreProductFormRequest $request)
    {
        $params = $request->except('_token');

        $product = $this->updateProduct($params);

        if (!$product) {
            return back()->with('error', 'Error occurred while updating product.');
        }
        return back()->with('success', 'Product updated successfully');
    }
}
