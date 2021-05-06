<?php

declare(strict_types=1);

namespace Zing\DingtalkRobot\Messages;

trait InteractsWithAt
{
    protected $at = [];

    /**
     * @param array|string|int $mobiles 被@人的手机号
     *
     * @throws \InvalidArgumentException
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
     * @param bool $atAll
     *
     * @return $this
     */
    public function atAll($atAll = true): self
    {
        $this->at['isAtAll'] = $atAll;

        return $this;
    }
}
