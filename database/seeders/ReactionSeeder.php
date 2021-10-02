<?php

namespace Database\Seeders;

use App\Models\Reaction;
use Illuminate\Database\Seeder;

class ReactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Reaction::createFromName('clap');
        Reaction::createFromName('fire');
        Reaction::createFromName('heart');
        Reaction::createFromName('joy_cat');
        Reaction::createFromName('money');
        Reaction::createFromName('pray');
        Reaction::createFromName('party');
        Reaction::createFromName('raised_hands');
    }
}
