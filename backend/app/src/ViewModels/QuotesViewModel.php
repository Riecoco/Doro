<?php

namespace App\ViewModels;

class QuotesViewModel
{
    public array $quotes;
    public int $totalPages;

    public function __construct(array $quotes, int $totalPages)
    {
        $this->quotes = $quotes;
        $this->totalPages = $totalPages;
    }
}