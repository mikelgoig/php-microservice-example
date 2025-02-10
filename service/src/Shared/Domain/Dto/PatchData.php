<?php

declare(strict_types=1);

namespace App\Shared\Domain\Dto;

final readonly class PatchData
{
    /**
     * @param array<string, mixed> $data
     */
    public function __construct(
        public array $data,
    ) {}

    public function value(string $key): mixed
    {
        return $this->data[$key];
    }

    public function hasKey(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    public function isEmpty(): bool
    {
        return count($this->data) === 0;
    }
}
