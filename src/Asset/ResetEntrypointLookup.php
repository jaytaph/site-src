<?php

declare(strict_types=1);

namespace App\Asset;

use Symfony\WebpackEncoreBundle\Asset\EntrypointLookupInterface;

final class ResetEntrypointLookup implements EntrypointLookupInterface
{
    private EntrypointLookupInterface $decorated;

    public function __construct(EntrypointLookupInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    /**
     * @return array<string>
     */
    public function getJavaScriptFiles(string $entryName): array
    {
        $this->decorated->reset();

        return $this->decorated->getJavaScriptFiles($entryName);
    }

    /**
     * @return array<string>
     */
    public function getCssFiles(string $entryName): array
    {
        $this->decorated->reset();

        return $this->decorated->getCssFiles($entryName);
    }

    public function reset(): void
    {
        $this->decorated->reset();
    }
}
