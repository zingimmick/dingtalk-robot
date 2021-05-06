<?php

declare(strict_types=1);

namespace Zing\DingtalkRobot\Messages;

class EmptyMessage implements Message
{
    public function type(): string
    {
        return 'empty';
    }

    public function toArray(): array
    {
        return [
            'msgtype' => $this->type(),
        ];
    }
}
