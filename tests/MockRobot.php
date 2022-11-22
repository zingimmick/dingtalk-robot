<?php

declare(strict_types=1);

namespace Zing\DingtalkRobot\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Zing\DingtalkRobot\Robot;

trait MockRobot
{
    protected function getAccessToken(): string
    {
        return (string) getenv('ROBOT_ACCESS_TOKEN') ?: 'robot-access-token';
    }

    protected function getSecret(): string
    {
        return (string) getenv('ROBOT_SECRET') ?: 'robot-secret';
    }

    protected function mock(): bool
    {
        return (string) getenv('MOCK') !== 'false';
    }

    /**
     * @var array<int, array{response: \Psr\Http\Message\MessageInterface}>
     */
    protected $container = [];

    protected function makeRobot(bool $success = true): Robot
    {
        $robot = new Robot($this->getAccessToken(), $this->getSecret());
        $handlerStack = $this->createHandler($this->mock(), $success);
        $client = new Client(
            [
                'base_uri' => Robot::BASE_URI,
                'handler' => $handlerStack,
            ]
        );

        $reflectionObject = new \ReflectionObject($robot);
        $reflectionProperty = $reflectionObject->getProperty('client');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($robot, $client);

        return $robot;
    }

    private function createHandler(bool $mock, bool $success): HandlerStack
    {
        $content = $success ? ResponseContentList::SUCCESS : ResponseContentList::ERROR;
        $handlerStack = HandlerStack::create($mock ? new MockHandler([new Response(200, [], $content)]) : null);

        $history = Middleware::history($this->container);
        $handlerStack->push($history);

        return $handlerStack;
    }
}
