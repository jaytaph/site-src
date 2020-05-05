<?php

declare(strict_types=1);

namespace App\Controller\Article;

use App\Repository\ArticleRepositoryInterface;
use Ramsey\Collection\AbstractCollection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

final class ListingController
{
    private Environment $renderer;

    private ArticleRepositoryInterface $repository;

    public function __construct(Environment $renderer, ArticleRepositoryInterface $repository)
    {
        $this->renderer = $renderer;
        $this->repository = $repository;
    }

    /**
     * @Route("/blog", name="article_list")
     */
    public function __invoke(): Response
    {
        return new Response($this->renderer->render('article/list.html.twig', [
            'articles' => $this->repository->getAll()->sort('getDate', AbstractCollection::SORT_DESC),
        ]));
    }
}
