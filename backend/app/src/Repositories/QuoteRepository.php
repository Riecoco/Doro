<?php

namespace App\Repositories;

use App\Models\Quote;
use App\Models\UpdateQuoteDTO;
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
        $sql = "SELECT * FROM Quotes WHERE id = :id";
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

    //patch update
    public function update(UpdateQuoteDTO $dto): ?Quote
    {
        if (!$dto->quoteID) {
            return null;
        }

        $allowedFields = ['text', 'author'];
        $fieldsToUpdate = array_filter(
                            $allowedFields,
                            fn($field) => $dto->hasField($field)
                        );
        $sql = "UPDATE Quotes SET " . implode(', ', array_map(fn($field) => "$field = :$field", $fieldsToUpdate)) . " WHERE id = :id";
        $values = [];
        foreach ($fieldsToUpdate as $field) {
            $values[$field] = $dto->$field;
        }
        $values['id'] = $dto->quoteID;

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($values);
        return $this->getById($dto->quoteID);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM Quotes WHERE id = :id";
        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
