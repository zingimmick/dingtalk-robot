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

    /**
     * @param bool $hide
     *
     * @return $this
     */
    public function hideAvatar($hide = true)
    {
        $this->hideAvatar = $hide ? 1 : 0;

        return $this;
    }

    /**
     * @param bool $horizontally
     *
     * @return $this
     */
    public function btnHorizontally($horizontally = true)
    {
        $this->btnOrientation = $horizontally ? 1 : 0;

        return $this;
    }

    public function type(): string
    {
        return 'actionCard';
    }

    public function toArray(): array
    {
        return [
            'msgtype' => $this->type(),
            'actionCard' => [
                'title' => $this->title,
                'text' => $this->text,
                'btnOrientation' => $this->btnOrientation,
                'hideAvatar' => $this->hideAvatar,
                'btns' => array_map(static function (Button $button) {
                    return $button->toArray();
                }, $this->btns),
            ],
        ];
    }
}
