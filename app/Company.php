<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name', 'website', 'email','file_name','file_path','file_mime'
    ];

}
