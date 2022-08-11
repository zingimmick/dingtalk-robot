<?php

declare(strict_types=1);

namespace Zing\DingtalkRobot;

use GuzzleHttp\Client;
use Zing\DingtalkRobot\Exceptions\CannotSendException;
use Zing\DingtalkRobot\Exceptions\InvalidArgumentException;
use Zing\DingtalkRobot\Messages\Message;
use Zing\DingtalkRobot\Messages\TextMessage;

class Robot
{
    /**
     * @var string
     */
    public const BASE_URI = 'https://oapi.dingtalk.com';

    /**
     * @var string Access token of robot webhook
     */
    private $accessToken;

    /**
     * @var string|null 密钥，机器人安全设置页面，加签一栏下面显示的SEC开头的字符串
     */
    private $secret;

    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * @param string $accessToken Access token of robot webhook
     * @param string|null $secret 密钥，机器人安全设置页面，加签一栏下面显示的SEC开头的字符串
     */
    public function __construct(string $accessToken, ?string $secret)
    {
        $this->accessToken = $accessToken;
        $this->secret = $secret;
        $this->client = new Client(
            [
                'base_uri' => self::BASE_URI,
            ]
        );
    }

    /**
     * @param \Zing\DingtalkRobot\Messages\Message|string|mixed $message
     *
     * @return array{errcode: int, errmsg: string}
     */
    public function send($message): array
    {
        if (\is_string($message)) {
            $message = new TextMessage($message);
        }

        if (! $message instanceof Message) {
            throw new InvalidArgumentException('invalid message');
        }

        $query = [
            'access_token' => $this->accessToken,
        ];
        if ($this->secret) {
            $timestamp = time() * 1000;

            $sign = self::sign($timestamp, $this->secret);

            $query['timestamp'] = $timestamp;
            $query['sign'] = $sign;
        }

        $response = $this->client->post('robot/send', [
            'query' => $query,
            'json' => $message->toArray(),
        ]);

        /** @var array{errcode: int, errmsg: string} $data */
        $data = json_decode($response->getBody()->getContents(), true);
        if ($data['errcode'] !== 0) {
            throw new CannotSendException($data['errmsg'], $data['errcode']);
        }

        return $data;
    }

    /**
     * @param string|int $timestamp 时间戳
     * @param string $secret 密钥
     *
     * @return string 签名
     */
    public static function sign($timestamp, string $secret): string
    {
        $data = $timestamp . "\n" . $secret;

        return base64_encode(hash_hmac('sha256', $data, $secret, true));
    }
}
