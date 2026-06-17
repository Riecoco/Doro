<?php

namespace App\Repositories\Interfaces;

use App\Models\Quote;
use App\Models\UpdateQuoteDTO;

interface IQuoteRepository
{
    public function create(Quote $quote): Quote;
    public function getById(int $id): ?Quote;
    public function getAll(int $offset, int $limit): array;
    public function update(UpdateQuoteDTO $dto): ?Quote;
    public function delete(int $id): bool;
}