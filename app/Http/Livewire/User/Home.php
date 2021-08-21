<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Carousel;

class Home extends Component
{
    public function render()
    {
        return view('livewire.user.home',[
            'categories' => Category::all(),
            'products' => Product::where('status', 1)->get(),
            'brands' => Brand::all(),
            'carousel' => Carousel::where('mobile_image', 0)->get(),
        ])->extends('user.layouts.user_one');
    }
}
