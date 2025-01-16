<?php

use Plow\Example;

it('foo', function (): void {
    $result = (new Example)->foo();

    expect($result)->toBe('bar');
});
