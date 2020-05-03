<?php

declare(strict_types=1);

namespace App\Repository\Article;

use App\Collection\ArticleCollection;
use App\Model\Article;
use App\Repository\ArticleRepositoryInterface;
use Github\Client;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

final class PublicGistArticleRepository implements ArticleRepositoryInterface
{
    private Client $client;

    private CacheInterface $cache;

    private string $githubUser;

    public function __construct(
        Client $client,
        CacheInterface $cache,
        string $githubUser
    ) {
        $this->client = $client;
        $this->cache = $cache;
        $this->githubUser = $githubUser;
    }

    public function getAll(): ArticleCollection
    {
        $gists = $this->cache->get('gist_list', function (ItemInterface $item): array {
            $item->expiresAfter(3600);

            return $this->client->user()->gists($this->githubUser);
        });

        $articles = \array_map(function (array $githubData): Article {
            $gist = $this->cache->get(
                'gist_' . $githubData['id'],
                function (ItemInterface $item) use ($githubData): array {
                    $item->expiresAfter(3600);

                    return $this->client->gist()->show($githubData['id']);
                }
            );
            $file = \array_shift($gist['files']);

            return new Article(
                $gist['id'],
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

    public function getById(string $id): Article
    {
        $gist = $this->cache->get(
            'gist_' . $id,
            function (ItemInterface $item) use ($id): array {
                $item->expiresAfter(3600);

                return $this->client->gist()->show($id);
            }
        );

        $file = \array_shift($gist['files']);
        $article = new Article(
            $gist['id'],
            $gist['description'],
            $file['content'],
            new \DateTime($gist['created_at']),
            $gist['html_url']
        );

        return $article->withFiles($gist['files']);
    }
}
