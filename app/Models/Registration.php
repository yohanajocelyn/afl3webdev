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

    public function submissions():HasMany {
        return $this->hasMany(Submission::class, 'registration_id');
    }

    public function presences():HasMany {
        return $this->hasMany(Presence::class, 'registration_id');
    }

    public static function allData() {
        return Registration::all();
    }
}
