<?php

declare(strict_types=1);

namespace Zing\DingtalkRobot\Messages;

use Zing\DingtalkRobot\Contracts\Arrayable;

class Link implements Arrayable
{
    public function __construct(
        private string $title,
        private string $messageURL,
        private string $picURL
    ) {
    }

    /**
     * @return array{title: string, messageURL: string, picURL: string}
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'messageURL' => $this->messageURL,
            'picURL' => $this->picURL,
        ];
    }
}
