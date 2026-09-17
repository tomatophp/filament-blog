<?php

namespace TomatoPHP\FilamentBlog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use TomatoPHP\FilamentBlog\FilamentBlog;

/**
 * @property int $id
 * @property int $account_id
 * @property string $action
 * @property mixed $log
 * @property string $model_type
 * @property string $model_id
 */
class AccountLog extends Model
{
    protected $fillable = [
        'account_id',
        'action',
        'log',
        'model_type',
        'model_id',
        'created_at',
    ];

    protected $casts = [
        'log' => 'json',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(FilamentBlog::accountModel(), 'account_id');
    }

    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
