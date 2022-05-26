<?php

declare(strict_types=1);

/** @var array $params */

use Yiisoft\Validator\Rule\Handler\Container\RuleHandlerContainer;
use Yiisoft\Validator\RuleHandlerResolverInterface;

return [
    RuleHandlerResolverInterface::class => [
        'class' => RuleHandlerContainer::class,
        '__construct()' => [
            'definitions' => $params['yiisoft/validator-rule-handler-container']['handlers'],
            'validate' => $params['yiisoft/validator-rule-handler-container']['validate'],
        ],
    ],
];
