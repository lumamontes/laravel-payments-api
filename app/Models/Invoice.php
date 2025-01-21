<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'amount',
        'status',
        'due_date',

        'user_id',
    ];

   protected $casts = [
        'due_date' => 'datetime',
    ];

    protected $table = 'invoices';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
   
}
