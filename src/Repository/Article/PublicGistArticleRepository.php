<?php

declare(strict_types=1);

namespace App\Repository\Article;

use App\Collection\ArticleCollection;
use App\Model\Article;
use App\Repository\ArticleRepositoryInterface;
use Github\Client;

final class PublicGistArticleRepository implements ArticleRepositoryInterface
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getAll(): ArticleCollection
    {
        $gists = $this->client->user()->gists('jibbarth');
        $articles = \array_map(function (array $githubData): Article {
            $gist = $this->client->gist()->show($githubData['id']);
            $file = \array_shift($gist['files']);

            return new Article(
                $gist['description'],
                $file['content'],
                new \DateTime($gist['created_at']),
                $gist['html_url']
            );
        }, \array_filter($gists, static function (array $githubData): bool {
            if (0 === \count($githubData['files'])) {
                return false;
            }
            $file = \array_shift($githubData['files']);
            // if first file is not in markdown, consider gist as not relevant

            return 'Markdown' === $file['language'] || 'text/markdown' === $file['type'];
        }));

        return new ArticleCollection($articles);
    }
}
