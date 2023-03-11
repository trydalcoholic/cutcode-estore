<?php

declare(strict_types=1);

namespace Domain\Catalog\ViewModels;

use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

final class CategoryViewModel
{
    use Makeable;

    public function homePage(): Collection|array
    {
        return Cache::rememberForever('category_home_page', static function () {
            return Category::query()
                ->homePage()
                ->get();
        });
    }
}
