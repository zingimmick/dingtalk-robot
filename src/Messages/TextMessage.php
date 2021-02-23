<?php

namespace Zing\DingtalkRobot\Messages;

class TextMessage implements Message
{
    use InteractsWithAt;

    private $message;

    /**
     * @param string $message
     */
    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function type(): string
    {
        return 'text';
    }

    public function toArray(): array
    {
        return [
            'msgtype' => $this->type(),
            'text' => [
                'content' => $this->message,
            ],
            'at' => $this->at,
        ];
    }
}
