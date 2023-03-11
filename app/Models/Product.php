<?php

namespace App\Models;

use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Support\Casts\PriceCast;
use Support\Traits\Models\HasImage;
use Support\Traits\Models\HasSlug;

class Product extends Model
{
    use HasFactory;
    use HasSlug;
    use HasImage;

    protected $fillable = [
        'title',
        'thumbnail',
        'price',
        'brand_id',
        'slug',
        'on_home_page',
        'sorting',
    ];

    protected $casts = [
        'price' => PriceCast::class,
    ];

    protected function imageDir(): string
    {
        return 'products';
    }

    public function scopeHomePage(Builder $query): void
    {
        $query->where('on_home_page', true)
            ->orderBy('sorting')
            ->limit(6);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
