<?php

namespace Way2Web\Entrance\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Class Password_reset
 * 
 * @package Entrance
 * @author David Bikanov <dbikanov@intothesource.com>
 */
class Password_reset extends Model
{
    public $timestamps      = false;
    public $fillable        = ['email', 'token', 'created_at'];
    
    protected $dates        = ['created_at'];
    protected $primaryKey   = 'email';
}
