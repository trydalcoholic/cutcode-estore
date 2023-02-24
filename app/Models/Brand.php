<?php

namespace App\Models;

use App\Traits\Models\HasImage;
use App\Traits\Models\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function scopeHomePage(Builder $query): void
    {
        $query->where('on_home_page', true)
            ->orderBy('sorting')
            ->limit(6);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
