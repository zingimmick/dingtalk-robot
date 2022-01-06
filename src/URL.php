<?php

namespace Zing\DingtalkRobot;

use GuzzleHttp\Psr7\Uri;

class URL
{
    public static function page(string $url, bool $pcSlide = false): string
    {
        return Uri::withQueryValues(new Uri('dingtalk://dingtalkclient/page/link'), [
            'url' => urlencode($url), 'pc_slide' => $pcSlide ? 'true' : 'false',
        ]);
    }

    public static function app(string $corpid, string $app_id, string $redirect_url, string $container_type = 'work_platform', string $redirect_type = 'jump'): string
    {
        return Uri::withQueryValues(new Uri('dingtalk://dingtalkclient/action/openapp'), [
            'corpid' => $corpid,
            'container_type' => $container_type,
            'app_id' => $app_id,
            'redirect_type' => $redirect_type,
            'redirect_url' => rawurlencode($redirect_url),
        ]);
    }

    public static function eapp(string $page, array $queryValues = []): string
    {
        return Uri::withQueryValues(new Uri(sprintf('eapp://%s', $page)), $queryValues);
    }
}
