<?php

declare(strict_types=1);

namespace Plow;

/**
 * @internal
 */
final class PlowConfig
{
    public static function configure(): PlowBuilder
    {
        return new PlowBuilder();
    }
}
