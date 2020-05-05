<?php

declare(strict_types=1);

namespace App\Repository;

use App\Collection\ProjectCollection;
use App\Model\Project;
use InvalidArgumentException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

final class FileProjectRepository implements ProjectRepositoryInterface
{
    private const FILENAME = 'projects.yaml';

    private ProjectCollection $projects;

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

        $this->projects = new ProjectCollection(\Safe\array_combine(\array_map(static function (Project $project) use ($slugger): string {
            return $slugger->slug($project->getName())->toString();
        }, $projects), $projects));
    }

    public function getByName(string $name): Project
    {
        $key = $this->slugger->slug($name)->toString();

        if (false === $this->projects->offsetExists($key)) {
            throw new InvalidArgumentException('Unable to find project with name ' . $name);
        }

        return $this->projects->offsetGet($key);
    }

    public function getAll(): ProjectCollection
    {
        return $this->projects;
    }
}
