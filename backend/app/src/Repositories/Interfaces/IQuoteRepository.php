<?php

namespace App\Repositories\Interfaces;

use App\Models\Quote;

interface IQuoteRepository
{
    public function create(Quote $quote): Quote;
    public function getById(int $id): ?Quote;
    public function getAll(): array;
    public function update(Quote $quote): ?Quote;
    public function delete(int $id): bool;
}