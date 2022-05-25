<?php

declare(strict_types=1);

/** @var array $params */

use Yiisoft\Validator\RuleHandlerResolverInterface;
use Yiisoft\Validator\Rules\Container\RuleHandlerContainer;

return [
    RuleHandlerResolverInterface::class => [
        'class' => RuleHandlerContainer::class,
        '__construct()' => [
            'definitions' => $params['yiisoft/validator-rule-handler-container']['handlers'],
            'validate' => $params['yiisoft/validator-rule-handler-container']['validate'],
        ],
    ],
];
