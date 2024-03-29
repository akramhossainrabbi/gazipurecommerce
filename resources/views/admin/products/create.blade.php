@extends('admin.layout.base')

@section('title', 'Add Product')

@section('css')
<link rel="stylesheet" href="{{ asset('admin/select/css/select2.min.css') }}">
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Add Product</h1>

@if (Session::has('success'))
<div class="alert alert-success" role="alert">
    {{ Session::get('success') }}
</div>
@endif
@if (Session::has('errors'))
<span class="text-danger">{{ Session::get('errors') }}</span>
@endif
<div class="row user justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="general">
                        <div class="tile">
                            <form action="{{ route('admin.product.store') }}" method="POST" role="form">
                                @csrf
                                <h3 class="tile-title">Product Information</h3>
                                <hr>
                                <div class="tile-body">
                                    <div class="form-group">
                                        <label class="control-label" for="name">Name</label>
                                        <input
                                            class="form-control @error('name') is-invalid @enderror"
                                            type="text"
                                            placeholder="Enter attribute name"
                                            id="name"
                                            name="name"
                                            value="{{ old('name') }}"
                                        />
                                        <div class="invalid-feedback active">
                                            <i class="fa fa-exclamation-circle fa-fw"></i> @error('name') <span>{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="sku">SKU</label>
                                                <input
                                                    class="form-control @error('sku') is-invalid @enderror"
                                                    type="text"
                                                    placeholder="Enter product sku"
                                                    id="sku"
                                                    name="sku"
                                                    value="{{ old('sku') }}"
                                                />
                                                <div class="invalid-feedback active">
                                                    <i class="fa fa-exclamation-circle fa-fw"></i> @error('sku') <span>{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="brand_id">Brand</label>
                                                <select name="brand_id" id="brand_id" class="form-control @error('brand_id') is-invalid @enderror">
                                                    <option value="0">Select a brand</option>
                                                    @foreach($brands as $brand)
                                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback active">
                                                    <i class="fa fa-exclamation-circle fa-fw"></i> @error('brand_id') <span>{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label" for="categories">Categories</label>
                                                <select name="categories[]" id="categories" class="form-control" multiple>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @foreach ($category->children as $childCategory)
                                                            @include('admin.products.child_category_for_create', ['child_category' => $childCategory])
                                                        @endforeach
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label" for="cost">Cost</label>
                                                <input
                                                    class="form-control @error('cost') is-invalid @enderror"
                                                    type="text"
                                                    placeholder="Enter product cost"
                                                    id="cost"
                                                    name="cost"
                                                    value="{{ old('cost') }}"
                                                />
                                                <div class="invalid-feedback active">
                                                    <i class="fa fa-exclamation-circle fa-fw"></i> @error('cost') <span>{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label" for="price">Price</label>
                                                <input
                                                    class="form-control @error('price') is-invalid @enderror"
                                                    type="text"
                                                    placeholder="Enter product price"
                                                    id="price"
                                                    name="price"
                                                    value="{{ old('price') }}"
                                                />
                                                <div class="invalid-feedback active">
                                                    <i class="fa fa-exclamation-circle fa-fw"></i> @error('price') <span>{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label" for="special_price">Special Price</label>
                                                <input
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="Enter product special price"
                                                    id="special_price"
                                                    name="special_price"
                                                    value="{{ old('special_price') }}"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="quantity">Quantity</label>
                                                <input
                                                    class="form-control @error('quantity') is-invalid @enderror"
                                                    type="number"
                                                    placeholder="Enter product quantity"
                                                    id="quantity"
                                                    name="quantity"
                                                    value="{{ old('quantity') }}"
                                                />
                                                <div class="invalid-feedback active">
                                                    <i class="fa fa-exclamation-circle fa-fw"></i> @error('quantity') <span>{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="weight">Weight</label>
                                                <input
                                                    class="form-control"
                                                    type="text"
                                                    placeholder="Enter product weight"
                                                    id="weight"
                                                    name="weight"
                                                    value="{{ old('weight') }}"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="description">Short Details</label>
                                        <textarea name="description" id="description" rows="8" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input"
                                                        type="checkbox"
                                                        id="status"
                                                        name="status"
                                                    />Status
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input"
                                                        type="checkbox"
                                                        id="featured"
                                                        name="featured"
                                                    />Featured
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="tile-footer">
                                    <div class="row d-print-none mt-2">
                                        <div class="col-12 text-right">
                                            <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Product</button>
                                            <a class="btn btn-danger" href="{{ route('admin.products.list') }}"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Go Back</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('admin/select/js/select2.min.js') }}"></script>
<script>
    $( document ).ready(function() {
        $('#categories').select2();
    });
</script>
@endsection