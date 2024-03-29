# Dingtalk Robot
<p align="center">
<a href="https://github.com/zingimmick/dingtalk-robot/actions"><img src="https://github.com/zingimmick/dingtalk-robot/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://codecov.io/gh/zingimmick/dingtalk-robot"><img src="https://codecov.io/gh/zingimmick/dingtalk-robot/branch/master/graph/badge.svg" alt="Code Coverage" /></a>
<a href="https://packagist.org/packages/zing/dingtalk-robot"><img src="https://poser.pugx.org/zing/dingtalk-robot/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/zing/dingtalk-robot"><img src="https://poser.pugx.org/zing/dingtalk-robot/downloads" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/zing/dingtalk-robot"><img src="https://poser.pugx.org/zing/dingtalk-robot/v/unstable.svg" alt="Latest Unstable Version"></a>
<a href="https://packagist.org/packages/zing/dingtalk-robot"><img src="https://poser.pugx.org/zing/dingtalk-robot/license" alt="License"></a>
<a href="https://codeclimate.com/github/zingimmick/dingtalk-robot/maintainability"><img src="https://api.codeclimate.com/v1/badges/1e97924fa1f2241f5a77/maintainability" alt="Code Climate" /></a>
</p>

> **Requires [PHP 8.0+](https://php.net/releases/)**

Require Dingtalk Robot using [Composer](https://getcomposer.org):

```bash
composer require zing/dingtalk-robot
```

## Usage

```php
use Zing\DingtalkRobot\Messages\ActionCardMessage;
use Zing\DingtalkRobot\Messages\Button;
use Zing\DingtalkRobot\Messages\FeedCardMessage;
use Zing\DingtalkRobot\Messages\Link;
use Zing\DingtalkRobot\Messages\LinkMessage;
use Zing\DingtalkRobot\Messages\MarkdownMessage;
use Zing\DingtalkRobot\Messages\SingleActionCardMessage;
use Zing\DingtalkRobot\Messages\TextMessage;
use Zing\DingtalkRobot\Robot;

$robot = new Robot('access_token', 'secret');

// text类型
$robot->send('我就是我, 是不一样的烟火');
$robot->send((new TextMessage('我就是我, 是不一样的烟火'))->atAll());

// markdown类型
$robot->send((new MarkdownMessage(
    '杭州天气',
    "#### 杭州天气 \n> 9度，西北风1级，空气良89，相对温度73%\n> ![screenshot](https://img.alicdn.com/tfs/TB1NwmBEL9TBuNjy1zbXXXpepXa-2400-1218.png)\n> ###### 10点20分发布 [天气](https://www.dingtalk.com) \n"
))->at('150XXXXXXXX'));

// link类型
$robot->send(new LinkMessage(
    '时代的火车向前开',
    '这个即将发布的新版本，创始人xx称它为红树林。而在此之前，每当面临重大升级，产品经理们都会取一个应景的代号，这一次，为什么是红树林',
    'https://www.dingtalk.com/s?__biz=MzA4NjMwMTA2Ng==&mid=2650316842&idx=1&sn=60da3ea2b29f1dcc43a7c8e4a7c97a16&scene=2&srcid=09189AnRJEdIiWVaKltFzNTw&from=timeline&isappinstalled=0&key=&ascene=2&uin=&devicetype=android-23&version=26031933&nettype=WIFI',
    'https://img.alicdn.com/tfs/TB1NwmBEL9TBuNjy1zbXXXpepXa-2400-1218.png'
));

// 整体跳转ActionCard类型
$robot->send(new SingleActionCardMessage(
    '乔布斯 20 年前想打造一间苹果咖啡厅，而它正是 Apple Store 的前身',
    '![screenshot](https://gw.alicdn.com/tfs/TB1ut3xxbsrBKNjSZFpXXcXhFXa-846-786.png)
 ### 乔布斯 20 年前想打造的苹果咖啡厅
 Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划',
    '阅读全文',
    'https://www.dingtalk.com/'
));

// 独立跳转ActionCard类型
$robot->send((new ActionCardMessage(
    '我 20 年前想打造一间苹果咖啡厅，而它正是 Apple Store 的前身',
    "![screenshot](https://img.alicdn.com/tfs/TB1NwmBEL9TBuNjy1zbXXXpepXa-2400-1218.png) \n\n #### 乔布斯 20 年前想打造的苹果咖啡厅 \n\n Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划",
    [
        new Button(
            '内容不错',
            'https://www.dingtalk.com/'
        ),
        new Button(
            '不感兴趣',
            'https://www.dingtalk.com/'
        ),
    ]
))->btnHorizontally()->hideAvatar());

// FeedCard类型
$robot->send(new FeedCardMessage(
    [
        new Link(
            '时代的火车向前开1',
            'https://www.dingtalk.com/',
            'https://img.alicdn.com/tfs/TB1NwmBEL9TBuNjy1zbXXXpepXa-2400-1218.png'
        ),
        new Link(
            '时代的火车向前开2',
            'https://www.dingtalk.com/',
            'https://img.alicdn.com/tfs/TB1NwmBEL9TBuNjy1zbXXXpepXa-2400-1218.png'
        ),
    ]
));
```

## License

Dingtalk Robot is an open-sourced software licensed under the [MIT license](LICENSE).
