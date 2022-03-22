<?php

declare(strict_types=1);

namespace Zing\DingtalkRobot\Messages;

class SingleActionCardMessage implements Message
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
    private $singleTitle;

    /**
     * @var string
     */
    private $singleURL;

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

    /**
     * @return array{msgtype: string, actionCard: array{title: string, text: string, singleTitle: string, singleURL: string}}
     */
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
