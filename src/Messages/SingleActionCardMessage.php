<?php

namespace Zing\DingtalkRobot\Messages;

class SingleActionCardMessage implements Message
{
    private $title;

    private $text;

    private $singleTitle;

    private $singleURL;

    /**
     * ActionCardMessage constructor.
     *
     * @param $text
     * @param $title
     * @param $singleTitle
     * @param $singleURL
     */
    public function __construct(string $title, string $text, string $singleTitle, string $singleURL)
    {
        $this->title = $title;
        $this->text = $text;
        $this->singleTitle = $singleTitle;
        $this->singleURL = $singleURL;
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
                'singleTitle' => $this->singleTitle,
                'singleURL' => $this->singleURL,
            ],
        ];
    }
}
