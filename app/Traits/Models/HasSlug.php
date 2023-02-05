<?php

declare(strict_types = 1);

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(static function (Model $item) {
            $item->slug = $item->slug ?? str($item->{self::slugFrom()})->slug();
        });
    }

    public static function slugFrom(): string
    {
        return 'title';
    }
}
