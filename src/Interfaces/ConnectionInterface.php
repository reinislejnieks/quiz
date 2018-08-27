<?php

namespace Quiz\Interfaces;

interface ConnectionInterface
{
    /**
     * @param string $table
     * @param array $conditions
     * @param array $columns
     * @param int $limit
     *
     * @return array
     */
    public function select(string $table, array $conditions = [], array $columns = [], int $limit): array;

    /**
     * @param string $table
     * @param string $primaryKey
     * @param array $attributes
     * @return bool
     */
    public function insert(string $table, string $primaryKey, array $attributes): bool;

    /**
     * @param string $table
     * @param string $primaryKey
     * @param array $attributes
     * @return bool
     */
    public function update(string $table, string $primaryKey, array $attributes): bool;

    /**
     * @param string $table
     * @return array
     */
    public function fetchColumns(string $table): array;

    /**
     * @return int
     */
    public function getLastInsertId(): int;
}
