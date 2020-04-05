<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ProjectRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

final class IndexController
{
    private Environment $twig;

    private ProjectRepositoryInterface $projectRepository;

    public function __construct(
        Environment $twig,
        ProjectRepositoryInterface $projectRepository
    ) {
        $this->twig = $twig;
        $this->projectRepository = $projectRepository;
    }

    /**
     * @Route("/", name="home")
     */
    public function __invoke(): Response
    {
        return new Response($this->twig->render('index.html.twig', [
            'projects' => $this->projectRepository->getAll(),
        ]));
    }
}
