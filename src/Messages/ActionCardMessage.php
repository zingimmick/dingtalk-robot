<?php

declare(strict_types=1);

namespace Zing\DingtalkRobot\Messages;

class ActionCardMessage implements Message
{
    private int $hideAvatar = 0;

    /**
     * ActionCardMessage constructor.
     *
     * @param array<\Zing\DingtalkRobot\Messages\Button> $btns
     */
    public function __construct(
        private string $title,
        private string $text,
        private array $btns = [],
        private int $btnOrientation = 0
    ) {
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
     * @return array{msgtype: string, actionCard: array{title: string, text: string, btnOrientation: int, hideAvatar: int, btns: array<mixed, array{title: string, actionURL: string}>}}
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
                'btns' => array_map(static fn (Button $button): array => $button->toArray(), $this->btns),
            ],
        ];
    }
}
