<?php

declare(strict_types=1);

namespace Zing\DingtalkRobot\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use ReflectionObject;
use Zing\DingtalkRobot\Robot;

trait MockRobot
{
    protected function getAccessToken()
    {
        return (string) getenv('ROBOT_ACCESS_TOKEN');
    }

    protected function getSecret()
    {
        return (string) getenv('ROBOT_SECRET');
    }

    protected function mock(): bool
    {
        return (string) getenv('MOCK') !== 'false';
    }

    protected $container = [];

    protected function makeRobot($success = true): Robot
    {
        $robot = new Robot($this->getAccessToken(), $this->getSecret());
        $handlerStack = $this->createHandler($this->mock(), $success);
        $client = new Client(
            [
                'base_uri' => Robot::BASE_URI,
                'handler' => $handlerStack,
            ]
        );

        $reflectionObject = new ReflectionObject($robot);
        $property = $reflectionObject->getProperty('client');
        $property->setAccessible(true);
        $property->setValue($robot, $client);

        return $robot;
    }

    private function createHandler($mock, $success): HandlerStack
    {
        $content = $success ? ResponseContentList::SUCCESS : ResponseContentList::ERROR;
        $handlerStack = HandlerStack::create($mock ? new MockHandler([new Response(200, [], $content)]) : null);

        $history = Middleware::history($this->container);
        $handlerStack->push($history);

        return $handlerStack;
    }
}
