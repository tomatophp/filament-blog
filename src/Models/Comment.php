<?php

namespace TomatoPHP\FilamentBlog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property int|null $parent_id
 * @property int $user_id
 * @property string $user_type
 * @property int $content_id
 * @property string $content_type
 * @property string $comment
 * @property float $rate
 * @property bool $is_active
 * @property string $created_at
 * @property string $updated_at
 */
class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = [
        'parent_id',
        'user_id',
        'user_type',
        'content_id',
        'content_type',
        'comment',
        'rate',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'rate' => 'float',
    ];

    public function user(): MorphTo
    {
        return $this->morphTo('user');
    }

    public function content(): MorphTo
    {
        return $this->morphTo('content');
    }
}
