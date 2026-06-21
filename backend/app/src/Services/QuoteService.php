<?php

namespace App\Services;

use App\Models\Quote;
use App\Models\UpdateQuoteDTO;
use App\Repositories\QuoteRepository;
use App\Services\Interfaces\IQuoteService;
use App\Repositories\Interfaces\IQuoteRepository;

class QuoteService implements IQuoteService
{

    private const PAGE_SIZE = 10;
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

    public function getRandom(): ?Quote
    {
        return $this->quoteRepository->getRandom();
    }

    /**
     * @return Quote[]
     * @param int $pageNumber
     */
    public function getAll(int $pageNumber): array
    {
        $offset = ($pageNumber - 1) * self::PAGE_SIZE;
        return $this->quoteRepository->getAll($offset, self::PAGE_SIZE);
    }

    public function getTotalQuotesPages(): int
    {
        $totalQuotes = $this->quoteRepository->getTotalQuotes();
        return (int)ceil($totalQuotes / self::PAGE_SIZE);
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