<?php

namespace App\Repositories;

use App\Models\Quote;
use App\Framework\Repository;
use App\Repositories\Interfaces\IQuoteRepository;

class QuoteRepository extends Repository implements IQuoteRepository
{
    public function create(Quote $quote): Quote
    {
        $sql = "INSERT INTO Quotes (text, author) VALUES (:text, :author)";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([
            ':text' => $quote->text,
            ':author' => $quote->author
        ]);
        $quote->quoteID = (int)$this->getConnection()->lastInsertId();
        return $quote;
    }

    public function getById(int $id): ?Quote
    {
        $sql = "SELECT * FROM Quotes WHERE quoteID = :id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch();
        return $data ? new Quote($data) : null;
    }

    /**
     * Summary of getAll
     * @return Quote[]
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM Quotes";
        $stmt = $this->getConnection()->query($sql);
        return array_map(fn($row) => new Quote($row), $stmt->fetchAll());
    }

    public function update(Quote $quote): ?Quote
    {
        if (!$quote->quoteID) {
            return null; // Can't update a quote without an ID
        }
        $sql = "UPDATE Quotes SET text = :text, author = :author WHERE quoteID = :id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([
            ':text' => $quote->text,
            ':author' => $quote->author,
            ':id' => $quote->quoteID
        ]);
        return $this->getById($quote->quoteID);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM Quotes WHERE quoteID = :id";
        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}