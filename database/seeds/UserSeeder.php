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
        /** @var \App\User $user */
        $user = \App\User::firstOrNew([
            'name' => 'Dev',
            'email' => 'support@codepier.io',
        ]);

        $user->fill([
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'remember_token' => str_random(10),
            'apn_token' => 'cdc273f76b2f1ea13dd88cc97c3f69150da9c03dc7eb72d862031842447a26e6',
        ]);

        $user->save();

        $token = $user->createToken('Token Name')->accessToken;

        $this->command->info('Created support@codepier.io / secret');
        $this->command->info('API Token : ');
        $this->command->info($token);
    }
}
