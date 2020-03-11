<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usersCount = max((int) $this->command->ask('How many users would you like?', 20), 1);

        factory(App\User::class)->states('john-doe')->create();
        factory(App\User::class, $usersCount)->create();

        //dd(get_class($doe), get_class($else));

        //$users = $else->concat([$doe]);
        //dd($users->count());
    }
}
