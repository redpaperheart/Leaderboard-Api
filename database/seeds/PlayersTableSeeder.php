<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class PlayersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Model::unguard();

        factory(App\Player::class, 20)->create();

        //Model::reguard();
    }
}
