<?php

declare(strict_types=1);

namespace Zing\DingtalkRobot\Messages;

class FeedCardMessage implements Message
{
    private $links;

    public function __construct($links)
    {
        $this->links = $links;
    }

    public function type(): string
    {
        return 'feedCard';
    }

    public function toArray(): array
    {
        return [
            'msgtype' => $this->type(),
            'feedCard' => [
                'links' => array_map(static function (Link $link) {
                    return $link->toArray();
                }, $this->links),
            ],
        ];
    }
}
