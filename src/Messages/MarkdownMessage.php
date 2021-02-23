<?php

namespace Zing\DingtalkRobot\Messages;

class MarkdownMessage implements Message
{
    use InteractsWithAt;

    private $title;

    private $text;

    public function __construct(string $title, string $text)
    {
        $this->title = $title;
        $this->text = $text;
    }

    public function type(): string
    {
        return 'markdown';
    }

    public function toArray(): array
    {
        return [
            'msgtype' => $this->type(),
            'markdown' => [
                'title' => $this->title,
                'text' => $this->text,
            ],
            'at' => $this->at,
        ];
    }
}
