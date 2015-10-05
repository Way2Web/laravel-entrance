<?php

namespace App;

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
    public $timestamps = false;
    protected $dates = ['created_at'];
}
