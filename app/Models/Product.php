<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'catalog_id',
        'title',
        'slug',
        'description',
        'price',
    ];

    protected function title (): Attribute
    {
        return Attribute::set(function ($title){
            return [
                'title' => $title,
                'slug' => Str::slug($title),
            ];
        });
    }

    public function catalog (): BelongsTo
    {
        return $this->belongsTo(Catalog::class);
    }

    public function specifications (): BelongsToMany
    {
        return $this->belongsToMany(Specification::class, 'products_specifications');
    }
}
