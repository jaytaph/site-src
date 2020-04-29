<?php

declare(strict_types=1);

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

final class Project
{
    private string $name;

    private string $description;
    /**
     * @Assert\Url()
     */
    private string $url;

    private string $role;

    public function __construct(string $name, string $description, string $url)
    {
        $this->name = $name;
        $this->description = $description;
        $this->url = $url;
        // TODO dynamisme
        $this->role = 'contributor';
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getRole(): string
    {
        return $this->role;
    }
}
