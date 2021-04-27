<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Group;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = ["ПИ/б-17-1-о", "ИС/б-17-1-о", "ИС/б-17-2-о", "ИВТ/б-17-1-о", "УТС/б-17-1-о"];
        foreach($groups as $group){
            Group::create([
                'name' => $group
            ]);
        }
    }
}
