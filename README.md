<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://yiisoft.github.io/docs/images/yii_logo.svg" height="100px">
    </a>
    <h1 align="center">Yii Validator Rule Handler Container</h1>
    <br>
</p>

> ⚠️ This package is deprecated. Its contents were moved to the [validator package itself](https://github.com/yiisoft/validator).

[![Latest Stable Version](https://poser.pugx.org/yiisoft/validator-rule-handler-container/v/stable.png)](https://packagist.org/packages/yiisoft/validator-rule-handler-container)
[![Total Downloads](https://poser.pugx.org/yiisoft/validator-rule-handler-container/downloads.png)](https://packagist.org/packages/yiisoft/validator-rule-handler-container)
[![Build status](https://github.com/yiisoft/validator-rule-handler-container/workflows/build/badge.svg)](https://github.com/yiisoft/validator-rule-handler-container/actions?query=workflow%3Abuild)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yiisoft/validator-rule-handler-container/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/yiisoft/validator-rule-handler-container/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/yiisoft/validator-rule-handler-container/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/yiisoft/validator-rule-handler-container/?branch=master)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fyiisoft%2Fvalidator-rule-handler-container%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/yiisoft/validator-rule-handler-container/master)
[![static analysis](https://github.com/yiisoft/validator-rule-handler-container/workflows/static%20analysis/badge.svg)](https://github.com/yiisoft/validator-rule-handler-container/actions?query=workflow%3A%22static+analysis%22)
[![type-coverage](https://shepherd.dev/github/yiisoft/validator-rule-handler-container/coverage.svg)](https://shepherd.dev/github/yiisoft/validator-rule-handler-container)

The package is a container for resolving [Yii Validator](https://github.com/yiisoft/validator) rule handlers. It
provides rule handler container based on [Yii Factory](https://github.com/yiisoft/factory) and uses
[Yii Definitions](https://github.com/yiisoft/definitions) syntax.

## Requirements

- PHP 8.0 or higher.

## Installation

The package could be installed with composer:

```shell
composer require yiisoft/validator-rule-handler-container --prefer-dist
```

## General usage

### Direct interaction with rule handler container

```php
use Yiisoft\Validator\Result;
use Yiisoft\Validator\Rule\RuleHandlerInterface;
use Yiisoft\Validator\ValidationContext;
use Yiisoft\Validator\Rule\Handler\Container\RuleHandlerContainer;

/**
 * Validates that the value is a Pi.
 */
final class PiHandler implements RuleHandlerInterface
{
    public function validate(mixed $value, object $rule, ?ValidationContext $context = null): Result
    {
        $result = new Result();

        if (!(\abs($value - M_PI) < PHP_FLOAT_EPSILON)) {
            $result->addError('Value must be Pi.', ['value' => $value]);
        }

        return $result;
    }
}

$ruleHandlerContainer = new RuleHandlerContainer(new MyContainer());
$ruleHandler = $ruleHandlerContainer->resolve(PiHandler::class);
```

- `MyContainer` is a container for resolving dependencies and  must be an instance of
  `Psr\Container\ContainerInterface`. [Yii Dependency Injection](https://github.com/yiisoft/di) implementation also can
  be used.
- You can optionally set [definitions](https://github.com/yiisoft/definitions) and disable their validation if needed.

Basically, the arguments are the same as in [Yii Factory](https://github.com/yiisoft/factory). Please refer to its docs
for more details.

Rule handlers are created only once, then cached and reused for repeated calls.

```php
$ruleHandler = $ruleHandlerContainer->create(PiHandler::class); // Returned from cache
````

### Using [Yii config](https://github.com/yiisoft/config)

```php
use Yiisoft\Di\Container;
use Yiisoft\Di\ContainerConfig;
use Yiisoft\Validator\RuleHandlerResolverInterface;
use Yiisoft\Validator\Rule\Handler\Container\RuleHandlerContainer;

// Need to be defined in params.php
$params = [
    'yiisoft/validator-rule-handler-container' => [
        'handlers' => [PiHandler::class => PiHandler::class],
        'validate' => true,
    ],
];

// Need to be defined in common.php
$config = [
    RuleHandlerResolverInterface::class => [
        'class' => RuleHandlerContainer::class,
        '__construct()' => [
            'definitions' => $params['yiisoft/validator-rule-handler-container']['handlers'],
            'validate' => $params['yiisoft/validator-rule-handler-container']['validate'],
        ],
    ]
];

$containerConfig = ContainerConfig::create()->withDefinitions($config); 
$container = new Container($containerConfig);
$ruleHandlerResolver = $container->get(RuleHandlerResolverInterface::class);        
$ruleHandler = $ruleHandlerResolver->resolve(PiHandler::class);
```

## Testing

### Unit testing

The package is tested with [PHPUnit](https://phpunit.de/). To run tests:

```shell
./vendor/bin/phpunit
```

### Mutation testing

The package tests are checked with [Infection](https://infection.github.io/) mutation framework with
[Infection Static Analysis Plugin](https://github.com/Roave/infection-static-analysis-plugin). To run it:

```shell
./vendor/bin/roave-infection-static-analysis-plugin
```

### Static analysis

The code is statically analyzed with [Psalm](https://psalm.dev/). To run static analysis:

```shell
./vendor/bin/psalm
```

## License

The Yii Validator Rule Handler Container is free software. It is released under the terms of the BSD License.
Please see [`LICENSE`](./LICENSE.md) for more information.

Maintained by [Yii Software](https://www.yiiframework.com/).

## Support the project

[![Open Collective](https://img.shields.io/badge/Open%20Collective-sponsor-7eadf1?logo=open%20collective&logoColor=7eadf1&labelColor=555555)](https://opencollective.com/yiisoft)

## Follow updates

[![Official website](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](https://www.yiiframework.com/)
[![Twitter](https://img.shields.io/badge/twitter-follow-1DA1F2?logo=twitter&logoColor=1DA1F2&labelColor=555555?style=flat)](https://twitter.com/yiiframework)
[![Telegram](https://img.shields.io/badge/telegram-join-1DA1F2?style=flat&logo=telegram)](https://t.me/yii3en)
[![Facebook](https://img.shields.io/badge/facebook-join-1DA1F2?style=flat&logo=facebook&logoColor=ffffff)](https://www.facebook.com/groups/yiitalk)
[![Slack](https://img.shields.io/badge/slack-join-1DA1F2?style=flat&logo=slack)](https://yiiframework.com/go/slack)
