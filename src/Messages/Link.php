<?php

declare(strict_types=1);

namespace Zing\DingtalkRobot\Messages;

use Zing\DingtalkRobot\Contracts\Arrayable;

class Link implements Arrayable
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $messageURL;

    /**
     * @var string
     */
    private $picURL;

    public function __construct(string $title, string $messageURL, string $picURL)
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
