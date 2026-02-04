<?php

declare(strict_types=1);

namespace App\Services\Importers;

use App\Models\Article;
use App\Models\Author;
use App\Models\Subject;
use Illuminate\Support\Arr;

class RisImporter
{
    /**
     * Import a RIS or EndNote (ENW) record represented as a normalized array.
     *
     * @param array<string, mixed> $record
     */
    public function import(array $record): Article
    {
        $article = Article::create([
            'title' => Arr::get($record, 'title'),
            'journal' => Arr::get($record, 'journal'),
            'doi' => Arr::get($record, 'doi'),
            'publication_date' => Arr::get($record, 'publication_date'),
            'abstract' => Arr::get($record, 'abstract'),
        ]);

        $authorIds = collect(Arr::get($record, 'authors', []))
            ->map(fn (string $name) => Author::firstOrCreate(['name' => $name])->id)
            ->all();

        $subjectIds = collect(Arr::get($record, 'subjects', []))
            ->map(fn (string $name) => Subject::firstOrCreate(['name' => $name])->id)
            ->all();

        $article->authors()->sync($authorIds);
        $article->subjects()->sync($subjectIds);

        return $article;
    }
}
