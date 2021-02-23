<?php

namespace Zing\DingtalkRobot\Messages;

class LinkMessage implements Message
{
    private $title;

    private $text;

    private $messageUrl;

    private $picUrl;

    public function __construct(string $title, string $text, string $messageUrl, string $picUrl = '')
    {
        $this->title = $title;
        $this->text = $text;
        $this->messageUrl = $messageUrl;
        $this->picUrl = $picUrl;
    }

    public function type(): string
    {
        return 'link';
    }

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
