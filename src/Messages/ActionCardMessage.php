<?php

declare(strict_types=1);

namespace Zing\DingtalkRobot\Messages;

class ActionCardMessage implements Message
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
     * @var int
     */
    private $hideAvatar = 0;

    /**
     * @var int
     */
    private $btnOrientation;

    /**
     * @var array<\Zing\DingtalkRobot\Messages\Button>
     */
    private $btns = [];

    /**
     * ActionCardMessage constructor.
     *
     * @param array<\Zing\DingtalkRobot\Messages\Button> $btns
     */
    public function __construct(string $title, string $text, array $btns = [], int $btnOrientation = 0)
    {
        $this->title = $title;
        $this->text = $text;
        $this->btnOrientation = $btnOrientation;
        $this->btns = $btns;
    }

    public function hideAvatar(bool $hide = true): self
    {
        $this->hideAvatar = $hide ? 1 : 0;

        return $this;
    }

    public function btnHorizontally(bool $horizontally = true): self
    {
        $this->btnOrientation = $horizontally ? 1 : 0;

        return $this;
    }

    public function type(): string
    {
        return 'actionCard';
    }

    /**
     * @return array<string, mixed[]>
     */
    public function toArray(): array
    {
        return [
            'msgtype' => $this->type(),
            'actionCard' => [
                'title' => $this->title,
                'text' => $this->text,
                'btnOrientation' => $this->btnOrientation,
                'hideAvatar' => $this->hideAvatar,
                'btns' => array_map(static function (Button $button): array {
                    return $button->toArray();
                }, $this->btns),
            ],
        ];
    }
}
