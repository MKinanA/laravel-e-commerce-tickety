<?php

namespace App\Models;

use App\Models\Ticket;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'ticket_id',
        'transaction_id',
        'is_reedemed',
    ];

    public function ticket(): BelongsTo {
        return $this->belongsTo(Ticket::class);
    }

    public function transaction(): BelongsTo {
        return $this->belongsTo(Transaction::class);
    }
}
