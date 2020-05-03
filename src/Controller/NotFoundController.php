<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * As we dump the site in static website on github pages
 * we have to render a 404.html page
 */
final class NotFoundController
{
    private Environment $renderer;

    public function __construct(Environment $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @Route("/404.html", name="not_found")
     */
    public function __invoke(): Response
    {
        return new Response($this->renderer->render('404.html.twig'));
    }
}
