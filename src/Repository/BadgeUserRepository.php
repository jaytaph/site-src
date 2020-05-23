<?php

declare(strict_types=1);

namespace App\Repository;

use App\Collection\BadgeCollection;
use App\Parser\VndComSymfonyConnectXmlParser;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use SymfonyCorp\Connect\Api\Api;
use SymfonyCorp\Connect\Api\Entity\Badge;
use function Symfony\Component\String\u;

final class BadgeUserRepository
{
    private Api $api;

    private HttpClientInterface $client;

    private string $userUuid;

    public function __construct(
        HttpClientInterface $client,
        VndComSymfonyConnectXmlParser $parser,
        string $sfConnectUser
    ) {
        $this->api = new Api(null, $client, $parser);
        $this->client = $client;
        $this->userUuid = $sfConnectUser;
    }

    public function getBadges(): BadgeCollection
    {
        $root = $this->api->getRoot();
        $user = $root->getUser($this->userUuid);
        $badges = $user->getBadges();
        $badges = \array_map(function (Badge $badge) use ($root): Badge {
            /** @var Badge $badge */
            $badge = $root->getBadge($badge->getId());

            $badge->setImage($this->resolveImage($badge->getImage()));

            return $badge;
        }, $badges->getItems());

        return new BadgeCollection($badges);
    }

    private function resolveImage(string $url): string
    {
        $response = $this->client->request('GET', $url);
        $response->getContent();

        return u($response->getInfo()['url'])->replace('30x30', '200x200')->toString();
    }
}
