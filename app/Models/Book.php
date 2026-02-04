<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\SearchIndexable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Book extends Model
{
    use SearchIndexable;

    protected $fillable = [
        'title',
        'subtitle',
        'isbn',
        'publication_date',
        'publisher_id',
        'description',
    ];

    protected $casts = [
        'publication_date' => 'date',
    ];

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class)->withTimestamps();
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class)->withTimestamps();
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function toSearchableArray(): array
    {
        return array_merge(parent::toSearchableArray(), [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'isbn' => $this->isbn,
            'publisher' => $this->publisher?->name,
            'authors' => $this->authors->pluck('name')->all(),
            'subjects' => $this->subjects->pluck('name')->all(),
        ]);
    }
}
