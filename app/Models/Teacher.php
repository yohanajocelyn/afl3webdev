<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'gender', 'phone_number', 'pfpURL', 'email', 'password', 'role', 'nuptk', 'community', 'subjectTaught'];

    public function school():BelongsTo {
        return $this->belongsTo(School::class);
    }

    public function registrations():HasMany {
        return $this->hasMany(Registration::class, 'teacher_id');
    }

    public static function allData() {
        return Teacher::all();
    }

}
