<?php

declare(strict_types=1);

namespace Zing\DingtalkRobot\Messages;

trait InteractsWithAt
{
    /**
     * @var array{atMobiles?: array<string|int>, isAtAll?: bool}
     */
    protected $at = [];

    /**
     * @param array<string|int>|string|int $mobiles 被@人的手机号
     *
     * @return $this
     */
    public function at($mobiles): self
    {
        $mobiles = is_array($mobiles) ? $mobiles : func_get_args();

        $this->at['atMobiles'] = $mobiles;

        return $this;
    }

    /**
     * 是否@所有人。
     *
     * @return $this
     */
    public function atAll(bool $atAll = true): self
    {
        $this->at['isAtAll'] = $atAll;

        return $this;
    }
}
