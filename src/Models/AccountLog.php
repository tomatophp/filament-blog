<?php

namespace TomatoPHP\FilamentBlog\Models;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'action',
        'log',
        'model_type',
        'model_id',
    ];

    protected $casts = [
        'log' => 'json',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function model()
    {
        return $this->morphTo();
    }
}
