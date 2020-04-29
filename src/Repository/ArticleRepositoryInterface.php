<?php

declare(strict_types=1);

namespace App\Repository;

use App\Collection\ArticleCollection;

interface ArticleRepositoryInterface
{
    public function getAll(): ArticleCollection;
}
