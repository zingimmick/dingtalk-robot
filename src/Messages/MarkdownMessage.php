<?php

declare(strict_types=1);

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
        if (isset($this->at['atMobiles'])) {
            foreach ($this->at['atMobiles'] as $mobile) {
                if (strpos($this->text, sprintf('@%s', $mobile)) === false) {
                    $this->text .= sprintf('@%s', $mobile);
                }
            }
        }

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
