<?php

declare(strict_types=1);

namespace Zing\DingtalkRobot\Messages;

class MarkdownMessage implements Message
{
    use InteractsWithAt;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
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

        foreach ((array) $this->at['atMobiles'] as $mobile) {
            if (strpos($this->text, sprintf('@%s', $mobile)) === false) {
                $this->text .= sprintf('@%s', $mobile);
            }
        }

        return $this->text;
    }
}
