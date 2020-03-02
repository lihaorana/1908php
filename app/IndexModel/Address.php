<?php

namespace App\IndexModel;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected  $table='address';
    protected $primaryKey='add_id';
    public $timestamps=false;
    protected  $guarded=[];

}
