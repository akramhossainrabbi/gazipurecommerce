<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Str;

class Brand extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

       /**
     * @var string
     */
    protected $table = 'brands';

    /**
     * @var array
     */
    protected $fillable = ['name', 'slug', 'logo'];

    /**
     * @param $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
