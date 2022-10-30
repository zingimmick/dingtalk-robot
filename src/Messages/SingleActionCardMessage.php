<?php

declare(strict_types=1);

namespace Zing\DingtalkRobot\Messages;

class SingleActionCardMessage implements Message
{
    public function __construct(
        private string $title,
        private string $text,
        private string $singleTitle,
        private string $singleURL
    ) {
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
