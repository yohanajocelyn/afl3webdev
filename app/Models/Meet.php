<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Meet extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'location',
        'workshop_id',
    ];

    public function workshop():BelongsTo {
        return $this->belongsTo(Workshop::class);
    }
}
