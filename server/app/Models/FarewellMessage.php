<?php
// app/Models/FarewellMessage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarewellMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'is_active',
        'usage_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function incrementUsage(): void
    {
        $this->increment('usage_count');
    }
}