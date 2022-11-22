<?php

declare(strict_types=1);

namespace Zing\DingtalkRobot\Messages;

class FeedCardMessage implements Message
{
    /**
     * @param array<\Zing\DingtalkRobot\Messages\Link> $links
     */
    public function __construct(
        private array $links
    ) {
    }

    public function type(): string
    {
        return 'feedCard';
    }

    /**
     * @return array{msgtype: string, feedCard: array{links: array<mixed, array{title: string, messageURL: string, picURL: string}>}}
     */
    public function toArray(): array
    {
        return [
            'msgtype' => $this->type(),
            'feedCard' => [
                'links' => array_map(static fn (Link $link): array => $link->toArray(), $this->links),
            ],
        ];
    }
}
