<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;


class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'is_done',
        'user_id', 'project_id'
    ];

    protected $casts = [
        'is_done' => 'boolean'
    ];



    public function user(): BelongsTo
    {
        return  $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return  $this->belongsTo(Project::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope('user', function (Builder $builder) {
            $builder->where('user_id', Auth::id());
        });
    }
}
