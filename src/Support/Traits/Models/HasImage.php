<?php

declare(strict_types=1);

namespace Support\Traits\Models;

use Illuminate\Support\Facades\File;

trait HasImage
{
    abstract protected function imageDir(): string;

    public function makeImage(string $size, string $method = 'resize'): string
    {
        return route('image', [
            'size' => $size,
            'dir' => $this->imageDir(),
            'method' => $method,
            'file' => File::basename($this->{$this->imageColumn()}),
        ]);
    }

    protected function imageColumn(): string
    {
        return 'thumbnail';
    }
}
