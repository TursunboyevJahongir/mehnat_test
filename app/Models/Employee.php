<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class Category
 * @package App\Models
 * @property int id
 * @property string first_name
 * @property string last_name
 * @property string fathers_name
 * @property string $full_name first last fathers name
 * @property int position_id
 * @property int company_id
 * @property string login
 * @property string password
 * @property string phone
 * @property string address
 * @property string passport
 * @property Company|belongsTo company
 * @property Company|hasOne director
 * @property Position|belongsTo position
 */
class Employee extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'fathers_name',
        'position_id',
        'company_id',
        'login',
        'password',
        'phone',
        'address',
        'passport',
    ];

    public function getFullNameAttribute(): string
    {
        return $this->first_name . " " . $this->last_name . " " . $this->fathers_name;
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function director(): HasOne
    {
        return $this->hasOne(Company::class, 'chief_id');
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
