<?php

namespace Domain\Catalog\Models;

use App\Models\Product;
use Domain\Catalog\QueryBuilders\BrandQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Traits\Models\HasImage;
use Support\Traits\Models\HasSlug;

/**
 * @method static Brand|BrandQueryBuilder query()
 */
class Brand extends Model
{
    use HasFactory;
    use HasSlug;
    use HasImage;

    protected function imageDir(): string
    {
        return 'brands';
    }

    protected $fillable = [
        'title',
        'thumbnail',
        'slug',
        'on_home_page',
        'sorting',
    ];

    public function newEloquentBuilder($query): BrandQueryBuilder
    {
        return new BrandQueryBuilder($query);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
