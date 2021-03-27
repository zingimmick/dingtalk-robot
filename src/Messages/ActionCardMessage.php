<?php

namespace Zing\DingtalkRobot\Messages;

class ActionCardMessage implements Message
{
    private $title;

    private $text;

    private $hideAvatar = 0;

    private $btnOrientation;

    private $btns;

    /**
     * ActionCardMessage constructor.
     *
     * @param $text
     * @param $title
     * @param array $btns
     * @param int $btnOrientation
     */
    public function __construct($title, $text, $btns = [], $btnOrientation = 0)
    {
        $this->title = $title;
        $this->text = $text;
        $this->btnOrientation = $btnOrientation;
        $this->btns = $btns;
    }

    public function hideAvatar($hide = true)
    {
        $this->hideAvatar = $hide ? 1 : 0;

        return $this;
    }

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
