<?php

declare(strict_types=1);

namespace Zing\DingtalkRobot\Messages;

use Zing\DingtalkRobot\Contracts\Arrayable;

interface Message extends Arrayable
{
    public function type(): string;
}
