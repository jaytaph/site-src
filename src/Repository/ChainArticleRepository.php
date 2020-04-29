<?php

declare(strict_types=1);

namespace App\Repository;

use App\Collection\ArticleCollection;

final class ChainArticleRepository implements ArticleRepositoryInterface
{
    /**
     * @var array<ArticleRepositoryInterface>
     */
    private array $repositories = [];

    /**
     * @param iterable<\App\Repository\ArticleRepositoryInterface> $articleRepositories
     */
    public function __construct(iterable $articleRepositories)
    {
        foreach ($articleRepositories as $articleRepository) {
            if ($articleRepository instanceof self) {
                continue;
            }

            $this->repositories[] = $articleRepository;
        }
    }

    public function getAll(): ArticleCollection
    {
        $articles = new ArticleCollection();
        $allArticles = [];
        /** @var ArticleRepositoryInterface $repository */
        foreach ($this->repositories as $repository) {
            $allArticles[] = $repository->getAll();
        }

        $articles = $articles->merge(...$allArticles);
        \assert($articles instanceof ArticleCollection);

        return $articles;
    }
}
