<?php

declare(strict_types=1);

namespace Zing\DingtalkRobot\Messages;

use Zing\DingtalkRobot\Contracts\Arrayable;

class Button implements Arrayable
{
    private $title;

    private $actionURL;

    /**
     * Button constructor.
     *
     * @param $title
     * @param $actionURL
     */
    public function __construct($title, $actionURL)
    {
        $this->title = $title;
        $this->actionURL = $actionURL;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'actionURL' => $this->actionURL,
        ];
    }
}
