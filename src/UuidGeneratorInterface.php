<?php

declare(strict_types=1);

namespace Whirlwind\Middleware\Uuid;

interface UuidGeneratorInterface
{
    public function generate(): string;
}
