<?php

declare(strict_types=1);

namespace Zing\DingtalkRobot\Messages;

use Zing\DingtalkRobot\Contracts\Arrayable;

class Button implements Arrayable
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $actionURL;

    public function __construct(string $title, string $actionURL)
    {
        $this->title = $title;
        $this->actionURL = $actionURL;
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
