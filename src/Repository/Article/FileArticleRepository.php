<?php

declare(strict_types=1);

namespace App\Repository\Article;

use App\Collection\ArticleCollection;
use App\Model\Article;
use App\Repository\ArticleRepositoryInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class FileArticleRepository implements ArticleRepositoryInterface
{
    private const FILENAME = 'articles.yaml';

    private SerializerInterface $serializer;

    private string $projectDir;

    public function __construct(SerializerInterface $serializer, string $projectDir)
    {
        $this->serializer = $serializer;
        $this->projectDir = $projectDir;
    }

    public function getAll(): ArticleCollection
    {
        $filename = $this->projectDir . \DIRECTORY_SEPARATOR . 'data' . \DIRECTORY_SEPARATOR . self::FILENAME;

        $articles = $this->serializer->deserialize(\file_get_contents($filename), Article::class . '[]', 'yaml');

        return new ArticleCollection($articles);
    }
}
