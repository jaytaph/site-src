<?php

declare(strict_types=1);

namespace App\Repository;

use App\Collection\ProjectCollection;
use App\Model\Project;

interface ProjectRepositoryInterface
{
    public function getByName(string $name): Project;

    public function getAll(): ProjectCollection;
}
