<?php

declare(strict_types=1);

namespace Zing\DingtalkRobot\Messages;

use Zing\DingtalkRobot\Contracts\Arrayable;

class Button implements Arrayable
{
    public function __construct(
        private string $title,
        private string $actionURL
    ) {
    }

    /**
     * @return array{title: string, actionURL: string}
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'actionURL' => $this->actionURL,
        ];
    }
}
