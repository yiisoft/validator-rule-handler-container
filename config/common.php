<?php

declare(strict_types=1);

/** @var array $params */

use Yiisoft\Validator\RuleHandlerResolverInterface;
use Yiisoft\Validator\Rules\Container\RuleHandlersContainer;

return [
    RuleHandlerResolverInterface::class => [
        'class' => RuleHandlersContainer::class,
        '__construct()' => [
            'definitions' => $params['yiisoft/validator-rules-container']['handlers'],
            'validate' => $params['yiisoft/validator-rules-container']['validate'],
        ],
    ],
];
