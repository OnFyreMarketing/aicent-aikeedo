<?php

declare(strict_types=1);

namespace Ai\Domain\ValueObjects;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Override;
use Shared\Domain\Exceptions\InvalidValueException;

#[ORM\Embeddable]
class Progress implements JsonSerializable
{
    #[ORM\Column(type: Types::SMALLINT, name: "progress", nullable: true)]
    public readonly ?int $value;

    public function __construct(?int $value = null)
    {
        $this->ensureValueIsValid($value);
        $this->value = $value;
    }

    #[Override]
    public function jsonSerialize(): ?int
    {
        return $this->value;
    }

    private function ensureValueIsValid(?int $value): void
    {
        if ($value !== null && ($value < 0 || $value > 100)) {
            throw new InvalidValueException(sprintf(
                '<%s> does not allow the value <%s>.',
                static::class,
                $value
            ));
        }
    }
}
