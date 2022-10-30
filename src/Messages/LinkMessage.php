<?php

declare(strict_types=1);

namespace Zing\DingtalkRobot\Messages;

class LinkMessage implements Message
{
    public function __construct(
        private string $title,
        private string $text,
        private string $messageUrl,
        private string $picUrl = ''
    ) {
    }

    public function type(): string
    {
        return 'link';
    }

    /**
     * @return array{msgtype: string, link: array{title: string, text: string, messageUrl: string, picUrl: string}}
     */
    public function toArray(): array
    {
        return [
            'msgtype' => $this->type(),
            'link' => [
                'title' => $this->title,
                'text' => $this->text,
                'messageUrl' => $this->messageUrl,
                'picUrl' => $this->picUrl,
            ],
        ];
    }
}
