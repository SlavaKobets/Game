<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $user_id
 * @property string $result
 * @property int $win
 * @property string $created_at
 * @property string $updated_at
 */
class History extends Model
{
    use HasFactory;

    protected $table = 'history';

    protected $fillable = [
        'user_id',
        'result',
        'win',
        'number'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
