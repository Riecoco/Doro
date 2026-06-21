<?php

namespace App\Services\Interfaces;

use App\Models\Quote;
use App\Models\UpdateQuoteDTO;

interface IQuoteService
{
    public function create(Quote $quote): Quote;
    public function getById(int $id): ?Quote;
    public function getRandom(): ?Quote;
    public function getAll(int $pageNumber): array;
    public function getTotalQuotesPages(): int;
    public function update(UpdateQuoteDTO $dto): ?Quote;
    public function delete(int $id): bool;
}