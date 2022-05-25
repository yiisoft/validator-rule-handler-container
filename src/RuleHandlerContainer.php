<?php

declare(strict_types=1);

namespace Yiisoft\Validator\Rules\Container;

use Psr\Container\ContainerInterface;
use Yiisoft\Factory\Factory;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Validator\Exception\RuleHandlerInterfaceNotImplementedException;
use Yiisoft\Validator\Exception\RuleHandlerNotFoundException;
use Yiisoft\Validator\Rule\RuleHandlerInterface;
use Yiisoft\Validator\RuleHandlerResolverInterface;

final class RuleHandlerContainer implements RuleHandlerResolverInterface
{
    private array $handlers = [];
    private Factory $factory;

    public function __construct(ContainerInterface $container, array $definitions = [], bool $validate = true)
    {
        $this->factory = new Factory($container, $definitions, $validate);
    }

    public function resolve(string $className): RuleHandlerInterface
    {
        if (!array_key_exists($className, $this->handlers)) {
            try {
                $ruleHandler = $this->factory->create($className);
            } catch (NotFoundException $e) {
                throw new RuleHandlerNotFoundException($className, $e);
            }

            if (!$ruleHandler instanceof RuleHandlerInterface) {
                throw new RuleHandlerInterfaceNotImplementedException($className);
            }

            return $this->handlers[$className] = $ruleHandler;
        }

        return $this->handlers[$className];
    }
}
