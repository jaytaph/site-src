<?php

declare(strict_types=1);

namespace App\Gif;

interface GifLinkProviderInterface
{
    public function getRandom(string $search): string;
}
