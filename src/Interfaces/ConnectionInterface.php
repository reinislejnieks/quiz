<?php

namespace Quiz\Interfaces;

interface ConnectionInterface
{
    public function select(string $table, array $condition = [], array $select = []): array;

    public function insert(string $table, string $primaryKey, array $attributes): bool;

    public function update(string $table, string $primaryKey, array $attributes): bool;

    public function fetchColumns(string $table): array;
}