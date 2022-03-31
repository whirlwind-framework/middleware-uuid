<?php

declare(strict_types=1);

namespace Whirlwind\Middleware\Uuid;

class UniqueIdGenerator implements UuidGeneratorInterface
{
    protected string $prefix;

    public function __construct(string $prefix = '')
    {
        $this->prefix = $prefix;
    }

    public function generate(): string
    {
        return \uniqid($this->prefix);
    }
}
