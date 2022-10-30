<?php

declare(strict_types=1);

namespace Zing\DingtalkRobot\Tests;

use GuzzleHttp\Psr7\Message;
use GuzzleHttp\Psr7\Response;
use Zing\DingtalkRobot\Exceptions\CannotSendException;
use Zing\DingtalkRobot\Exceptions\InvalidArgumentException;
use Zing\DingtalkRobot\Messages\ActionCardMessage;
use Zing\DingtalkRobot\Messages\Button;
use Zing\DingtalkRobot\Messages\EmptyMessage;
use Zing\DingtalkRobot\Messages\FeedCardMessage;
use Zing\DingtalkRobot\Messages\Link;
use Zing\DingtalkRobot\Messages\LinkMessage;
use Zing\DingtalkRobot\Messages\MarkdownMessage;
use Zing\DingtalkRobot\Messages\SingleActionCardMessage;
use Zing\DingtalkRobot\Messages\TextMessage;
use Zing\DingtalkRobot\Robot;

use function GuzzleHttp\Psr7\rewind_body;

/**
 * @internal
 */
final class RobotTest extends TestCase
{
    use MockRobot;

    /**
     * @return array<array<\Closure>>
     */
    public function messages(): array
    {
        $generators = [
            static fn (): string => '我就是我, 是不一样的烟火',
            static fn (): TextMessage => (new TextMessage('我就是我, 是不一样的烟火'))
                ->atAll(),
            static fn (): MarkdownMessage => (new MarkdownMessage(
                '杭州天气',
                "#### 杭州天气 \n> 9度，西北风1级，空气良89，相对温度73%\n> ![screenshot](https://img.alicdn.com/tfs/TB1NwmBEL9TBuNjy1zbXXXpepXa-2400-1218.png)\n> ###### 10点20分发布 [天气](https://www.dingtalk.com) \n"
            ))->at('150XXXXXXXX'),
            static fn (): MarkdownMessage => new MarkdownMessage(
                '杭州天气',
                "#### 杭州天气 \n> 9度，西北风1级，空气良89，相对温度73%\n> ![screenshot](https://img.alicdn.com/tfs/TB1NwmBEL9TBuNjy1zbXXXpepXa-2400-1218.png)\n> ###### 10点20分发布 [天气](https://www.dingtalk.com) \n"
            ),
            static fn (): LinkMessage => new LinkMessage(
                '时代的火车向前开',
                '这个即将发布的新版本，创始人xx称它为红树林。而在此之前，每当面临重大升级，产品经理们都会取一个应景的代号，这一次，为什么是红树林',
                'https://www.dingtalk.com/s?__biz=MzA4NjMwMTA2Ng==&mid=2650316842&idx=1&sn=60da3ea2b29f1dcc43a7c8e4a7c97a16&scene=2&srcid=09189AnRJEdIiWVaKltFzNTw&from=timeline&isappinstalled=0&key=&ascene=2&uin=&devicetype=android-23&version=26031933&nettype=WIFI',
                'https://img.alicdn.com/tfs/TB1NwmBEL9TBuNjy1zbXXXpepXa-2400-1218.png'
            ),
            static fn (): SingleActionCardMessage => new SingleActionCardMessage(
                '乔布斯 20 年前想打造一间苹果咖啡厅，而它正是 Apple Store 的前身',
                '![screenshot](https://gw.alicdn.com/tfs/TB1ut3xxbsrBKNjSZFpXXcXhFXa-846-786.png)
 ### 乔布斯 20 年前想打造的苹果咖啡厅
 Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划',
                '阅读全文',
                'https://www.dingtalk.com/'
            ),
            static fn (): ActionCardMessage => (new ActionCardMessage(
                '我 20 年前想打造一间苹果咖啡厅，而它正是 Apple Store 的前身',
                "![screenshot](https://img.alicdn.com/tfs/TB1NwmBEL9TBuNjy1zbXXXpepXa-2400-1218.png) \n\n #### 乔布斯 20 年前想打造的苹果咖啡厅 \n\n Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划",
                [
                    new Button('内容不错', 'https://www.dingtalk.com/'),
                    new Button('不感兴趣', 'https://www.dingtalk.com/'),
                ]
            ))->btnHorizontally()
                ->hideAvatar(),
            static fn (): FeedCardMessage => new FeedCardMessage(
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
            ),
        ];

        return array_map(static fn ($generator): array => [$generator], $generators);
    }

    /**
     * @dataProvider messages
     */
    public function testSend(\Zing\DingtalkRobot\Messages\Message|string|callable $messageGenerator): void
    {
        $robot = $this->makeRobot();
        $message = \is_callable($messageGenerator) ? $messageGenerator() : $messageGenerator;
        $robot->send($message);
        self::assertCount(1, $this->container);
        $response = $this->container[0]['response'];
        self::assertInstanceOf(Response::class, $response);
        if (\function_exists('\GuzzleHttp\Psr7\rewind_body')) {
            rewind_body($response);
        } else {
            Message::rewindBody($response);
        }

        self::assertSame(ResponseContentList::SUCCESS, $response->getBody()->getContents());
    }

    public function testSendInvalidMessage(): void
    {
        $robot = $this->makeRobot();
        $this->expectException(InvalidArgumentException::class);
        $robot->send(1);
    }

    public function testSendWrongMessage(): void
    {
        $robot = $this->makeRobot(false);
        $this->expectException(CannotSendException::class);
        $robot->send(new FeedCardMessage([]));
    }

    public function testSign(): void
    {
        self::assertSame('amkLsBkk5EosJmCHy4jULhWijmFkrFuDirC8ZpzHWpY=', Robot::sign(1_614_076_018_000, 'test'));
    }

    public function testEmptyMessage(): void
    {
        $emptyMessage = new EmptyMessage();
        self::assertSame('empty', $emptyMessage->type());
        self::assertSame([
            'msgtype' => 'empty',
        ], $emptyMessage->toArray());
    }
}
