<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\WebpackEncoreBundle\Asset\EntrypointLookupInterface;
use Twig\Environment;

/**
 * As we dump the site in static website on github pages
 * we have to render a 404.html page
 */
final class NotFoundController
{
    private Environment $renderer;

    private EntrypointLookupInterface $entrypointLookup;

    public function __construct(Environment $renderer, EntrypointLookupInterface $entrypointLookup)
    {
        $this->renderer = $renderer;
        $this->entrypointLookup = $entrypointLookup;
    }

    /**
     * @Route("/404.html", name="not_found")
     */
    public function __invoke(): Response
    {
        $this->entrypointLookup->reset();

        return new Response($this->renderer->render('404.html.twig'));
    }
}
