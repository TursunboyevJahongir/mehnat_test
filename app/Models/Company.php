<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Category
 * @package App\Models
 * @property int id
 * @property string name
 * @property int $chief_id Корхона раҳбари
 * @property int creator_id
 * @property string address
 * @property string email
 * @property string phone
 * @property string site
 * @property Employee|hasMany employees
 * @property Employee|belongsTo $chief Корхона раҳбари
 * @property Admin|belongsTo creator
 */
class Company extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'name',
        'chief_id',
        'creator_id',
        'email',
        'site',
        'phone',
        'address',
    ];

    /**
     * @return HasMany
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'creator_id');
    }

    public function chief(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'chief_id');
    }
}
