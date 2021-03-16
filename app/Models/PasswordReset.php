<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PasswordReset
 * @package App\Models
 * @property int id
 * @property string email
 * @property string token
 */
class PasswordReset extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = [
        'email',
        'token'
    ];
}
