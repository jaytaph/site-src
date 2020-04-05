<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Project;

interface ProjectRepositoryInterface
{
    public function getByName(string $name): Project;

    /**
     * @return array<string, \App\Model\Project>
     */
    public function getAll(): array;
}
