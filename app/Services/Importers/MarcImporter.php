<?php

declare(strict_types=1);

namespace App\Services\Importers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Publisher;
use App\Models\Subject;
use Illuminate\Support\Arr;

class MarcImporter
{
    /**
     * Import a MARC record represented as a normalized array.
     *
     * @param array<string, mixed> $record
     */
    public function import(array $record): Book
    {
        $publisher = Publisher::firstOrCreate([
            'name' => Arr::get($record, 'publisher.name', 'Unknown Publisher'),
        ]);

        $book = Book::create([
            'title' => Arr::get($record, 'title'),
            'subtitle' => Arr::get($record, 'subtitle'),
            'isbn' => Arr::get($record, 'isbn'),
            'publication_date' => Arr::get($record, 'publication_date'),
            'publisher_id' => $publisher->id,
            'description' => Arr::get($record, 'description'),
        ]);

        $authorIds = collect(Arr::get($record, 'authors', []))
            ->map(fn (string $name) => Author::firstOrCreate(['name' => $name])->id)
            ->all();

        $subjectIds = collect(Arr::get($record, 'subjects', []))
            ->map(fn (string $name) => Subject::firstOrCreate(['name' => $name])->id)
            ->all();

        $book->authors()->sync($authorIds);
        $book->subjects()->sync($subjectIds);

        return $book;
    }
}
