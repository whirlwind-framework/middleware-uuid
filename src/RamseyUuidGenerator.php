<?php

declare(strict_types=1);

namespace Whirlwind\Middleware\Uuid;

use Ramsey\Uuid\Uuid as UuidFactory;

class RamseyUuidGenerator implements UuidGeneratorInterface
{
    public function generate(): string
    {
        return UuidFactory::uuid4()->toString();
    }
}
