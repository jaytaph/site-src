<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class SocialExtension extends AbstractExtension
{
    private Environment $render;

    /**
     * @var array<string, array<string>>
     */
    private array $social;

    /**
     * @param array<string, array<string>> $social
     */
    public function __construct(Environment $render, array $social)
    {
        $this->render = $render;
        $this->social = $social;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('social_link', [$this, 'socialLink'], ['is_safe' => ['html']]),
        ];
    }

    public function socialLink(): string
    {
        return $this->render->render('social.html.twig', ['data' => $this->social]);
    }
}
