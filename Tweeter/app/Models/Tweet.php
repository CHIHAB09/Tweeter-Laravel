<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tweet extends Model
{

    use HasFactory;

    //variable proteger 
    protected $guarded = [];

    //un tweet appartient un user 
    public function user()
    {
        //la methode belongsTo() permet de cree un nv model enfant venu d un model parent
        return $this->belongsTo(User::class);
    }

    //creation de la function pour formater la date
    public function getCreatedAtAttribute($date)
    {
        // on utilise la class carbon et on utilise la variable $date , Laravel va comprendre
        //pour injecter une date
        //on parse pour formater et on lui ajoute la methode format()
        //en entrant la maniere dont on veut le formater
        return Carbon:: parse($date)->format('d M. Y');
    }
}
