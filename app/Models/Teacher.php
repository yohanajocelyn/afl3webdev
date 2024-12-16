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
    protected $fillable = ['name', 'gender', 'phone_number', 'pfpURL', 'role', 'email', 'password', 'nuptk', 'community', 'subjectTaught', 'school_id'];

    protected $casts = [
        'role' => Role::class,
    ];

    public function school():BelongsTo {
        return $this->belongsTo(School::class);
    }

    public function registrations():HasMany {
        return $this->hasMany(Registration::class, 'teacher_id');
    }

    public static function allData() {
        return Teacher::all();
    }

    public static function dataWithId($id){
        return self::find($id);
    }

    public static function dataWithSchoolId($id){
        $teachersFromSchool = static::allData();
        return $teachersFromSchool -> where('school_id', $id);
        return Teacher::find($id);
    }
}
