<?php

namespace App\Services;

use App\Models\Quote;
use App\Models\UpdateQuoteDTO;
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
     * @return Quote[]
     */
    public function getAll(): array
    {
        return $this->quoteRepository->getAll();
    }

    public function update(UpdateQuoteDTO $dto): ?Quote
    {
        return $this->quoteRepository->update($dto);
    }

    public function delete(int $id): bool
    {
        return $this->quoteRepository->delete($id);
    }
}