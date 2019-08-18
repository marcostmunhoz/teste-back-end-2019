<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name'     => 'Suporte',
            'email'    => 'suporte@dindigital.com',
            'password' => bcrypt('secret')
        ]);
        
        factory(\App\Product::class, 10)->create();
    }
}
