<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\SearchIndexable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Article extends Model
{
    use SearchIndexable;

    protected $fillable = [
        'title',
        'journal',
        'doi',
        'publication_date',
        'abstract',
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

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function toSearchableArray(): array
    {
        return array_merge(parent::toSearchableArray(), [
            'title' => $this->title,
            'journal' => $this->journal,
            'doi' => $this->doi,
            'authors' => $this->authors->pluck('name')->all(),
            'subjects' => $this->subjects->pluck('name')->all(),
        ]);
    }
}
