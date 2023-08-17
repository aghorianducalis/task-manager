<?php

namespace App\Models;

use App\Models\Enums\TaskStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property \App\Models\Enums\TaskStatusEnum $status
 * @property \Carbon\Carbon $due_date
 * @property int $user_id
 */
class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'title',
        'description',
        'status',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'date',
        'status'   => TaskStatusEnum::class,
    ];

    /**
     * The user that related to the task.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
