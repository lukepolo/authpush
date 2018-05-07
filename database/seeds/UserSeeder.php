<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var \App\Models\User $user */
        $user = \App\Models\User::firstOrNew([
            'name' => 'Dev',
            'email' => 'support@codepier.io',
        ]);

        $user->fill([
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'remember_token' => str_random(10),
        ]);

        $user->save();

        $token = $user->createToken('Token Name')->accessToken;

        $this->command->info('Created support@codepier.io / secret');
        $this->command->info('API Token : ');
        $this->command->info($token);
    }
}
