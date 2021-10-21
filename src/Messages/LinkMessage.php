<?php

declare(strict_types=1);

namespace Zing\DingtalkRobot\Messages;

class LinkMessage implements Message
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $messageUrl;

    /**
     * @var string
     */
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

    /**
     * @return array<string, mixed>
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
