<?php

declare(strict_types=1);

namespace App\Parser;

/** @phpstan-ignore-next-line */
final class VndComSymfonyConnectXmlParser extends \SymfonyCorp\Connect\Api\Parser\VndComSymfonyConnectXmlParser
{
    protected function getLinkToFoafDepiction(\DOMElement $element): string
    {
        return (string) $this->getLinkNodeHref('./atom:link[@rel="https://rels.connect.symfony.com/image"]', $element);
    }
}
