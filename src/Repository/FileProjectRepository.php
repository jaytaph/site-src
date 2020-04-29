<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Project;
use InvalidArgumentException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

final class FileProjectRepository implements ProjectRepositoryInterface
{
    private const FILENAME = 'projects.yaml';

    /**
     * @var array<string, Project>
     */
    private array $projects;

    private SluggerInterface $slugger;

    public function __construct(SerializerInterface $serializer, SluggerInterface $slugger, string $projectDir)
    {
        $filename = $projectDir . \DIRECTORY_SEPARATOR . 'data' . \DIRECTORY_SEPARATOR . self::FILENAME;

        $this->slugger = $slugger;
        /** @var array<Project> $projects */
        $projects = $serializer->deserialize(
            \file_get_contents($filename),
            Project::class . '[]',
            'yaml'
        );

        $this->projects = \Safe\array_combine(\array_map(static function (Project $project) use ($slugger): string {
            return $slugger->slug($project->getName())->toString();
        }, $projects), $projects);
    }

    public function getByName(string $name): Project
    {
        $key = $this->slugger->slug($name)->toString();

        if (!\array_key_exists($key, $this->projects)) {
            throw new InvalidArgumentException('Unable to found project with name ' . $name);
        }

        return $this->projects[$key];
    }

    /**
     * @return array<string, Project>
     */
    public function getAll(): array
    {
        return $this->projects;
    }
}
