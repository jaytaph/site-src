<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ArticleRepositoryInterface;
use App\Repository\ProjectRepositoryInterface;
use Ramsey\Collection\CollectionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

final class IndexController
{
    private Environment $twig;

    private ProjectRepositoryInterface $projectRepository;

    private ArticleRepositoryInterface $articleRepository;

    public function __construct(
        Environment $twig,
        ProjectRepositoryInterface $projectRepository,
        ArticleRepositoryInterface $articleRepository
    ) {
        $this->twig = $twig;
        $this->projectRepository = $projectRepository;
        $this->articleRepository = $articleRepository;
    }

    /**
     * @Route("/", name="home")
     */
    public function __invoke(): Response
    {
        return new Response($this->twig->render('index.html.twig', [
            'projects' => $this->projectRepository->getAll(),
            'articles' => $this->articleRepository->getAll()->sort('getDate', CollectionInterface::SORT_DESC),
        ]));
    }
}
