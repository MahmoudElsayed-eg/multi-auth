<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'status',
        'pic'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilters(Builder $query, array $filters): Builder
    {
        return $query
            ->when(
                $filters['status'] ?? null,
                fn($q, $status) =>
                $q->where('status', $status)
            )
            ->when(
                $filters['user_id'] ?? null,
                fn($q, $userId) =>
                $q->where('user_id', $userId)
            )->when(
                $filters['search'] ?? null,
                fn($q, $search) =>
                $q->where(function ($q2) use ($search) {
                    $q2->where('title', 'like', "%$search%")
                        ->orWhere('content', 'like', "%$search%");
                })
            );
    }
}
