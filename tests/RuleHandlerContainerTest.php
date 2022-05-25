<?php

namespace Yiisoft\Validator\Rules\Container\Tests;

use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Test\Support\Container\SimpleContainer;
use PHPUnit\Framework\TestCase;
use Yiisoft\Validator\Exception\RuleHandlerInterfaceNotImplementedException;
use Yiisoft\Validator\Exception\RuleHandlerNotFoundException;
use Yiisoft\Validator\Rule\RuleHandlerInterface;
use Yiisoft\Validator\Rules\Container\RuleHandlerContainer;
use Yiisoft\Validator\Rules\Container\Tests\Support\PiHandler;

class RuleHandlerContainerTest extends TestCase
{
    public function testCreate(): void
    {
        $handlersContainer = new RuleHandlerContainer(new SimpleContainer());

        $handler = $handlersContainer->resolve(PiHandler::class);

        $this->assertInstanceOf(PiHandler::class, $handler);
    }

    public function testNotFound(): void
    {
        $handlersContainer = new RuleHandlerContainer(new SimpleContainer());

        $this->expectException(RuleHandlerNotFoundException::class);
        $this->expectExceptionMessage(
            'Handler was not found for "not-exists-handler" rule or unresolved "not-exists-handler" class.'
        );
        $this->expectExceptionCode(0);
        $handlersContainer->resolve('not-exists-handler');
    }

    public function testNotRuleInterface(): void
    {
        $handlersContainer = new RuleHandlerContainer(new SimpleContainer(), ['handler' => new \stdClass()]);

        $this->expectException(RuleHandlerInterfaceNotImplementedException::class);
        $this->expectExceptionMessage('Handler "handler" should implement "' . RuleHandlerInterface::class . '".');
        $this->expectExceptionCode(0);
        $handlersContainer->resolve('handler');
    }

    public function testValidation(): void
    {
        $container = new SimpleContainer();
        $definitions = ['handler' => 42];

        $this->expectException(InvalidConfigException::class);
        new RuleHandlerContainer($container, $definitions);
    }

    public function testDisableValidation(): void
    {
        $handlersContainer = new RuleHandlerContainer(new SimpleContainer(), ['handler' => 42], false);

        $this->expectException(InvalidConfigException::class);
        $handlersContainer->resolve('handler');
    }
}
