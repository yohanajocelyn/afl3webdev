<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Registration extends Model
{
    use HasFactory;
    protected $fillable = ['regDate', 'paymentProof', 'isApproved', 'courseStatus'];

    public function teacher():BelongsTo {
        return $this->belongsTo(Teacher::class);
    }

    public function workshop():BelongsTo {
        return $this->belongsTo(Workshop::class);
    }

    public static function allData() {
        return Registration::all();
    }
}
