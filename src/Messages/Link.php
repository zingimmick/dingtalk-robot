<?php

declare(strict_types=1);

namespace Zing\DingtalkRobot\Messages;

use Zing\DingtalkRobot\Contracts\Arrayable;

class Link implements Arrayable
{
    private $title;

    private $messageURL;

    private $picURL;

    /**
     * Link constructor.
     *
     * @param $title
     * @param $messageURL
     * @param $picURL
     */
    public function __construct($title, $messageURL, $picURL)
    {
        $this->title = $title;
        $this->messageURL = $messageURL;
        $this->picURL = $picURL;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'messageURL' => $this->messageURL,
            'picURL' => $this->picURL,
        ];
    }
}
