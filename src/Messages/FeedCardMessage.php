<?php

declare(strict_types=1);

namespace Zing\DingtalkRobot\Messages;

class FeedCardMessage implements Message
{
    /**
     * @var array<\Zing\DingtalkRobot\Messages\Link>
     */
    private $links = [];

    /**
     * @param array<\Zing\DingtalkRobot\Messages\Link> $links
     */
    public function __construct(array $links)
    {
        $this->links = $links;
    }

    public function type(): string
    {
        return 'feedCard';
    }

    /**
     * @return array<string, mixed[]>
     */
    public function toArray(): array
    {
        return [
            'msgtype' => $this->type(),
            'feedCard' => [
                'links' => array_map(static function (Link $link): array {
                    return $link->toArray();
                }, $this->links),
            ],
        ];
    }
}
