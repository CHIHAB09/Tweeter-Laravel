<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tweet extends Model
{

    use HasFactory;

    //un tweet appartient un user 
    public function user()
    {
        //la methode belongsTo() permet de cree un nv model enfant venu d un model parent
        return $this->belongsTo('User::class');
    }
}
