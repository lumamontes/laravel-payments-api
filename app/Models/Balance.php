<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    use HasFactory;

    protected $fillable = [
        'balance',
        'user_id',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
    ];

    protected $table = 'balances';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
