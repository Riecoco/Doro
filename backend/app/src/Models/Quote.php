<?php

namespace App\Models;

use App\Framework\Annotations\Required;
use App\Framework\Model;

class Quote extends Model
{
    public int $quoteID;
    #[Required]
    public string $text;
    #[Required]
    public string $author;

    public function __construct($data = [])
    {
        $this->quoteID = $data['quoteID'] ?? 0;
        $this->text = $data['text'] ?? '';
        $this->author = $data['author'] ?? 'Unknown Author';
    }
}