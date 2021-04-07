<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

     // function qui va nous faire fonctionner tous nos factorie cree avant
    public function run()
    {
        //va cree 10 user automatiquement, on ajoute plusieur tweet a chak user, on le fait grace
        //a la methode each()
        \App\Models\User::factory(10)->create()->each(
            //function flecher 
            //l utilisateur je lui donne tweet je chaine saveMany qui est relier ac hasMany
            //j appel le model tweet 
            fn ($user) => $user->tweets()->saveMany(\App\Models\Tweet::factory(5)->make())
        );
    }
}
