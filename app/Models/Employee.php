<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Category
 * @package App\Models
 * @property int id
 * @property string first_name
 * @property string last_name
 * @property string fathers_name
 * @property int position_id
 * @property string login
 * @property string password
 * @property string phone
 * @property string address
 * @property string passport
 * @property Company|hasOne company
 * @property Position|belongsTo position
 */
class Employee extends Model
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

//    public function company(): BelongsTo
//    {
//        return $this->belongsTo(Company::class);
//    }

    public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'chief_id');
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }
}
