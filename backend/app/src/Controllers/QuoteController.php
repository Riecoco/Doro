<?php

namespace App\Controllers;

use App\Models\Quote;
use App\Models\UpdateQuoteDTO;
use App\ViewModels\QuotesViewModel;
use App\Services\QuoteService;
use App\Services\Interfaces\IQuoteService;

class QuoteController extends BaseController
{
    private IQuoteService $quoteService;

    public function __construct()
    {
        parent::__construct();
        $this->quoteService = new QuoteService();
    }

    public function getAll()
    {
        $this->authenticateAdmin();
        try {
            $pageNumber = $this->getPageNumber();
            $quotes = $this->quoteService->getAll($pageNumber);
            $totalQuotes = $this->quoteService->getTotalQuotesPages();
            $viewModel = new QuotesViewModel($quotes, $totalQuotes);
            if(empty($quotes)) {
                return $this->sendErrorResponse('No quotes found', 404);
            }
            return $this->sendSuccessResponse($viewModel);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Oops, something went wrong!', 500);
        }
    }

    public function getById($vars=[])
    {
        $this->authenticateAdmin();
        try {
            $quote = $this->quoteService->getById($vars['id']);
            if ($quote) {
                return $this->sendSuccessResponse($quote);
            } else {
                return $this->sendErrorResponse('Quote not found', 404);
            }
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Oops, something went wrong!', 500);
        }
    }

    public function getRandom()
    {
        $this->authenticateAdmin();
        try {
            $quote = $this->quoteService->getRandom();
            if ($quote) {
                return $this->sendSuccessResponse($quote);
            } else {
                return $this->sendErrorResponse('No quotes found', 404);
            }
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Oops, something went wrong!', 500);
        }
    }

    public function create()
    {
        $this->authenticateAdmin();
        try {
            $quote = $this->mapPostDataToClass(Quote::class);
            $createdQuote = $this->quoteService->create($quote);
            return $this->sendSuccessResponse($createdQuote, 201);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Oops, something went wrong!', 500);
        }
    }

    public function update($vars=[])
    {
        $this->authenticateAdmin();
        try {
            $updateDto = $this->mapPostDataToClass(UpdateQuoteDTO::class);
            $updateDto->quoteID = $vars['id'];
            $updatedQuote = $this->quoteService->update($updateDto);
            if ($updatedQuote) {
                return $this->sendSuccessResponse($updatedQuote);
            } else {
                return $this->sendErrorResponse('Update failed', 500);
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return $this->sendErrorResponse('Oops, something went wrong!', 500);
        }
    }

    public function delete($vars=[])
    {
        $this->authenticateAdmin();
        try {
            $result = $this->quoteService->delete($vars['id']);
            if ($result) {
                return $this->sendSuccessResponse(['message' => 'Quote deleted successfully']);
            } else {
                return $this->sendErrorResponse('Quote not found', 404);
            }
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Oops, something went wrong!', 500);
        }
    }
}