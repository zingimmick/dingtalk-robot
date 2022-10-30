<?php

declare(strict_types=1);

namespace Zing\DingtalkRobot\Messages;

class MarkdownMessage implements Message
{
    use InteractsWithAt;

    public function __construct(
        private string $title,
        private string $text
    ) {
    }

    public function type(): string
    {
        return 'markdown';
    }

    /**
     * @return array{msgtype: string, markdown: array{title: string, text: string}, at: array{atMobiles?: array<string|int>, isAtAll?: bool}}
     */
    public function toArray(): array
    {
        return [
            'msgtype' => $this->type(),
            'markdown' => [
                'title' => $this->title,
                'text' => $this->formattedText(),
            ],
            'at' => $this->at,
        ];
    }

    private function formattedText(): string
    {
        if (! isset($this->at['atMobiles'])) {
            return $this->text;
        }

        foreach ($this->at['atMobiles'] as $mobile) {
            if (! str_contains($this->text, sprintf('@%s', $mobile))) {
                $this->text .= sprintf('@%s', $mobile);
            }
        }

        return $this->text;
    }
}
