<?php

namespace App\Models;

use App\Http\Helpers\CatalogHelper;
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
                'slug' => date('YmdHis').'-'.Str::slug($title),
            ];
        });
    }

    public function scopeSearch($query, $search)
    {
        $query->when($search, function ($q, $s) {
            $q->where("title", "regexp", $s)
                ->orWhere("description", "regexp", $s);
        });
    }

    public function scopeCatalog($query, $catalog)
    {
        $query->when($catalog, function ($q, $c) {
            $q->whereIn("catalog_id", CatalogHelper::getIdsByParentId($c));
        });
    }

    public function catalog (): BelongsTo
    {
        return $this->belongsTo(Catalog::class);
    }

    public function specifications (): BelongsToMany
    {
        return $this->belongsToMany(Specification::class, 'products_specifications')->as('detail')->withPivot('value');
    }
}
