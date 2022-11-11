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
    public function run(): void
    {
        Reaction::createFromName('clap');
        Reaction::createFromName('fire');
        Reaction::createFromName('handshake');
        Reaction::createFromName('joy');
        Reaction::createFromName('love');
        Reaction::createFromName('money');
        Reaction::createFromName('pray');
        Reaction::createFromName('party');
    }
}
