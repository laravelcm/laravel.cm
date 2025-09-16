<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\CompleteDynamicPropertiesRector;
use Rector\Config\RectorConfig;
use Rector\EarlyReturn\Rector\Return_\ReturnBinaryOrToEarlyReturnRector;
use Rector\ValueObject\PhpVersion;
use RectorLaravel\Rector\ClassMethod\AddGenericReturnTypeToRelationsRector;
use RectorLaravel\Rector\MethodCall\AssertStatusToAssertMethodRector;
use RectorLaravel\Rector\StaticCall\DispatchToHelperFunctionsRector;
use RectorLaravel\Rector\StaticCall\EloquentMagicMethodToQueryBuilderRector;
use RectorLaravel\Set\LaravelLevelSetList;
use RectorLaravel\Set\LaravelSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/app',
        __DIR__.'/app-modules',
        __DIR__.'/config',
        __DIR__.'/resources',
        __DIR__.'/tests',
    ])
    ->withSets([
        LaravelLevelSetList::UP_TO_LARAVEL_120,
        LaravelSetList::LARAVEL_CODE_QUALITY,
        LaravelSetList::LARAVEL_COLLECTION,
    ])
    ->withRules([
        AddGenericReturnTypeToRelationsRector::class,
        AssertStatusToAssertMethodRector::class,
        DispatchToHelperFunctionsRector::class,
        EloquentMagicMethodToQueryBuilderRector::class,
    ])
    ->withSkip([
        __DIR__.'/app/Listeners',
        ReturnBinaryOrToEarlyReturnRector::class,
        CompleteDynamicPropertiesRector::class,
    ])
    ->withPhpVersion(PhpVersion::PHP_84)
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        typeDeclarations: true,
        earlyReturn: true,
        strictBooleans: true,
    );
