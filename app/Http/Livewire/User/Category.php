<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category as Categories;
use App\Models\Brand;

class Category extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $category;
    public $slug;
    public $selectedbrands = [];
    public $startPrice, $endPrice;
    public $searched;

    public function priceRange($formData)
    {
        $this->startPrice = $formData['priceFrom'];
        $this->endPrice = $formData['priceTo'];
    }

    public function mount($slug)
    {
        $this->slug  =  $slug;
    }

    public function render()
    {
        $this->category = Categories::where('slug', $this->slug)->where('menu', 1)->first();
        return view('livewire.user.category',[
            'products' => $this->category->products()
                ->when($this->startPrice OR $this->endPrice, function($query){
                    $query->whereBetween('price', [$this->startPrice,$this->endPrice]);
                })
                ->when($this->selectedbrands, function($query){
                    $query->whereIn('brand_id', $this->selectedbrands);
                })
                ->when($this->searched, function($query){
                    $query->where('name', 'LIKE', '%' . $this->searched . '%');
                })
                ->paginate(30),
            'brands' => Brand::all(),
        ])->extends('user.layouts.user_one');
    }
}