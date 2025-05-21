<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Enums\Role;

class Teacher extends Authenticatable
{
    use HasFactory;
    protected $fillable = ['name', 'phone_number', 'email', 'password', 'nuptk', 'community', 'school_id', 'mentor_id'];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class, 'teacher_id');
    }

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(Mentor::class);
    }

    public static function allData()
    {
        return Teacher::all();
    }

    public static function dataWithId($id)
    {
        return self::find($id);
    }

    public static function dataWithSchoolId($id)
    {
        $teachersFromSchool = static::allData();
        return $teachersFromSchool->where('school_id', $id);
        return Teacher::find($id);
    }
}
