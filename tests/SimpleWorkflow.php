<?php

use Plow\PlowConfig;
use Symfony\Component\Yaml\Yaml;

it('generate simple yaml file with "name"', function (): void {
    PlowConfig::configure()
        ->withName('Tests 1')
        ->build('/../tests/Fixtures/');

    $content = file_get_contents(__DIR__ . '/Fixtures/tests-1.yml');
    $data = Yaml::parse($content);

    expect($data['name'])->toBe('Tests 1');
});

it('generate simple yaml file one trigger on push branches main', function (): void {
    PlowConfig::configure()
        ->withName('Tests 2')
        ->withTriggers([
            ['push' => ['branches' => ['main']]]
        ])
        ->build('/../tests/Fixtures/');

    $content = file_get_contents(__DIR__ . '/Fixtures/tests-2.yml');
    $data = Yaml::parse($content);

    expect($data['name'])->toBe('Tests 2')
        ->and($data['on'])->not->toBeEmpty()
        ->and($data['on'])->toEqual([
            'push' => ['branches' => ['main']]
        ]);
});

it('generate simple yaml file multiple trigger on push, pull request', function (): void {
    PlowConfig::configure()
        ->withName('Tests 3')
        ->withTriggers(['push', 'pull_request'])
        ->build('/../tests/Fixtures/');

    $content = file_get_contents(__DIR__ . '/Fixtures/tests-3.yml');
    $data = Yaml::parse($content);

    expect($data['name'])->toBe('Tests 3')
        ->and($data['on'])->not->toBeEmpty()
        ->and($data['on'])->toEqual([
            'push', 'pull_request'
        ]);
});
