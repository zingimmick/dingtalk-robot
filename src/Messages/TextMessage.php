<?php

declare(strict_types=1);

namespace Zing\DingtalkRobot\Messages;

class TextMessage implements Message
{
    use InteractsWithAt;

    /**
     * @var string
     */
    private $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function type(): string
    {
        return 'text';
    }

    /**
     * @return array{msgtype: string, text: array{content: string}, at: array{atMobiles?: int[]|string[], isAtAll?: bool}}
     */
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
