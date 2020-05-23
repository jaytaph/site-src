<?php

declare(strict_types=1);

namespace App\Collection;

use Ramsey\Collection\AbstractCollection;
use SymfonyCorp\Connect\Api\Entity\Badge;

final class BadgeCollection extends AbstractCollection
{
    public function getType(): string
    {
        return Badge::class;
    }
}
