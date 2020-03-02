<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admins extends Model
{
    protected  $table='admins';
    protected $primaryKey='uid';
    public $timestamps=false;
    protected  $guarded=[];
}
