<?php

declare(strict_types=1);

namespace Billing\Domain\ValueObjects;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Override;

#[ORM\Embeddable]
class Code implements JsonSerializable
{
    #[ORM\Column(type: Types::STRING, name: "code", unique: true)]
    public readonly string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    #[Override]
    public function jsonSerialize(): string
    {
        return $this->value;
    }
}
