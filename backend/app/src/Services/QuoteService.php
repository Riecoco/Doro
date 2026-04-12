<?php

namespace App\Services;

use App\Models\Quote;
use App\Repositories\QuoteRepository;
use App\Services\Interfaces\IQuoteService;
use App\Repositories\Interfaces\IQuoteRepository;

class QuoteService implements IQuoteService
{
    private IQuoteRepository $quoteRepository;

    public function __construct()
    {
        $this->quoteRepository = new QuoteRepository();
    }

    public function create(Quote $quote): Quote
    {
        return $this->quoteRepository->create($quote);
    }

    public function getById(int $id): ?Quote
    {
        return $this->quoteRepository->getById($id);
    }

    /**
     * Summary of getAll
     * @return Quote[]
     */
    public function getAll(): array
    {
        return $this->quoteRepository->getAll();
    }

    public function update(Quote $quote): ?Quote
    {
        return $this->quoteRepository->update($quote);
    }

    public function delete(int $id): bool
    {
        return $this->quoteRepository->delete($id);
    }
}