<?php

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
     * @param string $accessToken
     * @param string|null $secret 密钥，机器人安全设置页面，加签一栏下面显示的SEC开头的字符串
     */
    public function __construct(string $accessToken, ?string $secret)
    {
        $this->accessToken = $accessToken;
        $this->secret = $secret;
        $this->client = new Client(
            [
                'base_uri' => 'https://oapi.dingtalk.com',
            ]
        );
    }

    /**
     * @param \Zing\DingtalkRobot\Messages\Message|string $message
     *
     * @throws \GuzzleHttp\Exception\GuzzleException|\Zing\DingtalkRobot\Exceptions\CannotSendException
     *
     * @return mixed
     */
    public function send($message)
    {
        if (is_string($message)) {
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

        $response = $this->client->post(
            'robot/send',
            [
                'query' => $query,
                'json' => $message->toArray(),
            ]
        );
        $data = json_decode($response->getBody()->getContents(), true);
        if ($data['errcode'] !== 0) {
            throw new CannotSendException($data['errmsg']);
        }

        return $data;
    }

    public static function sign($timestamp, $secret): string
    {
        $data = $timestamp . "\n" . $secret;

        return base64_encode(hash_hmac('sha256', $data, $secret, true));
    }
}
