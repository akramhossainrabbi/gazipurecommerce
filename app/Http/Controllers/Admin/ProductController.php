<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductFormRequest;
use App\Models\ProductAttribute;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use App\Models\Attribute;
use App\Models\Variant;
use App\Models\Category;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductDescription;
use Illuminate\Http\Request;
use Auth;



use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Auth::guard('admin')->user()->products;
        // $products = Product::get();
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

            $admin_id = Auth::guard('admin')->user()->id;

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
        $product = Product::findOrFail($id);
        $product_description = ProductDescription::where('product_id', $id)->first();
        $brands = Brand::all();
        $categories = Category::with('children')->whereNull('category_id')->get();
        $product_attributes = $product->attributes;
        $product_variations =  ProductVariant::where('product_id', $product->id)->get();
        $attributes = Attribute::all();
        $variations = Variant::all();

        return view('admin.products.edit', compact('categories', 'brands', 'product', 'product_description', 'attributes', 'product_attributes', 'variations', 'product_variations'));
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

    public function deleteProduct(Product $product)
    {
        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully.');
    }

    public function storeDescription(Request $request)
    {
        $product_description = ProductDescription::where('product_id', $request->product_id)->first();
        if ($product_description) {
            $product_description->description = $request->description_textarea;
            $product_description->save();
            return redirect()->back()->with('success', 'Product description added successfully.');
        }else { 
            $product_description = new ProductDescription;
            $product_description->product_id = $request->product_id;
            $product_description->description = $request->description_textarea;
            $product_description->save();

            return redirect()->back()->with('success', 'Product description added successfully.');
        }
    
    }

    public function storeDescriptionImg(Request $request)
    {
        $product = new Product;
        $product->id = 0;
        $product->exists = true;
        $image = $product->addMediaFromRequest('upload')->toMediaCollection('description', 'description');

        return response()->json([
            'url' => $image->getUrl()
        ]);
    
    }

    public function uploadImage(Request $request)
    {
        $product = Product::find($request->product_id);

        if ($request->has('image')) {

            $product->addMediaFromRequest('image')
                ->withResponsiveImages()
                ->toMediaCollection('products', 'products');
        }

        return response()->json(['status' => 'success']);
    }

    public function deleteImage(Product $product, $id)
    {
        $media = $product->getMedia('products');
        $image = $media->where('id', $id)->first();
        $image->delete();
        return redirect()->back()->with('success', 'Product image deleted successfully.');
    }

    public function storeAttribute(Request $request)
    {
        $productAttribute = new ProductAttribute;
        $productAttribute->value = $request->value;
        $productAttribute->quantity = $request->quantity;
        $productAttribute->price = $request->price;
        $productAttribute->product_id = $request->product_id;
        $productAttribute->attribute_id = $request->attribute_id;
        if ($productAttribute->save()) {
            return back()->with('success', 'Product attribute added successfully.');
        } else {
            return back()->with('error', 'Something went wrong while submitting product attribute.');
        }
    }

    public function storeVariation(Request $request)
    {
        $productVariation = new ProductVariant;
        $productVariation->value = $request->value;
        $productVariation->quantity = $request->quantity;
        $productVariation->price = $request->price;
        $productVariation->product_id = $request->product_id;
        $productVariation->variant_id = $request->variation_id;
        $productVariation->product_attribute_id = $request->product_attribute_id;
        if ($productVariation->save()) {
            return back()->with('success', 'Product variation added successfully.');
        } else {
            return back()->with('error', 'Something went wrong while submitting product variation.');
        }
    }

    public function deleteAttribute($id)
    {
        $productAttribute = ProductAttribute::findOrFail($id );
        $productAttribute->delete();

        return back()->with('success', 'Product attribute deleted successfully.');
    }
    public function deleteVariation($id)
    {
        $productAttribute = ProductVariant::findOrFail($id );
        $productAttribute->delete();

        return back()->with('success', 'Product variation deleted successfully.');
    }
}
