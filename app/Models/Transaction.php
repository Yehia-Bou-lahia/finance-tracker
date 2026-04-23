<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'type',
        'date',
        'description',
    ];

    protected $casts = [
        'date' => 'date',       // يحول التاريخ إلى كائن Carbon تلقائياً
        'amount' => 'decimal:2', // يضمن التعامل مع المبلغ كـ decimal
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}