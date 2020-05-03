<?php

declare(strict_types=1);

namespace App\Controller;

use App\Constant\ArticleType;
use App\Repository\ArticleRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symplify\SymfonyStaticDumper\Contract\ControllerWithDataProviderInterface;
use Twig\Environment;

final class ArticleController implements ControllerWithDataProviderInterface
{
    private Environment $renderer;

    private ArticleRepositoryInterface $articleRepository;

    public function __construct(Environment $renderer, ArticleRepositoryInterface $articleRepository)
    {
        $this->renderer = $renderer;
        $this->articleRepository = $articleRepository;
    }

    /**
     * @Route("/{type}/{article}", name="article_detail")
     */
    public function __invoke(string $type, string $article): Response
    {
        $article = $this->articleRepository->getById($article);

        return new Response($this->renderer->render(\Safe\sprintf('article/%s.html.twig', $type), [
            'article' => $article,
        ]));
    }

    public function getControllerClass(): string
    {
        return __CLASS__;
    }

    public function getControllerMethod(): string
    {
        return '__invoke';
    }

    /**
     * @return array<array<string>>
     */
    public function getArguments(): array
    {
        $collection = $this->articleRepository->getAll();

        $arguments = [];

        /** @var \App\Model\Article $article */
        foreach ($collection as $article) {
            if (ArticleType::EXTERNAL === $article->getType()) {
                continue;
            }
            $arguments[] = [$article->getType(), $article->getId()];
        }

        return [...$arguments];
    }
}
