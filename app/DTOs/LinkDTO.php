<?php

namespace App\DTOs;

readonly class LinkDTO
{
    public function __construct(
        public string $urlName,
        public string $shortUrlName,
        public int $userId
    ) {}
}
