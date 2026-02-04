<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Article;
use App\Models\Book;
use Illuminate\Support\Collection;

class SearchService
{
    /**
     * Basic placeholder search that can be replaced with Laravel Scout.
     */
    public function search(string $query): Collection
    {
        $books = Book::query()
            ->where('title', 'like', "%{$query}%")
            ->orWhere('isbn', 'like', "%{$query}%")
            ->get();

        $articles = Article::query()
            ->where('title', 'like', "%{$query}%")
            ->orWhere('doi', 'like', "%{$query}%")
            ->get();

        return $books->concat($articles);
    }
}
