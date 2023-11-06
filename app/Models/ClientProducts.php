<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientProducts extends Model
{
    use HasFactory;

    protected $fillable = ['order_id','Data'];
}
