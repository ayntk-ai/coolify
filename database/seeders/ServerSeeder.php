<?php

namespace Database\Seeders;

use App\Models\Server;
use App\Enums\ProxyTypes;
use Illuminate\Database\Seeder;

class ServerSeeder extends Seeder
{
    public function run(): void
    {
        $server = Server::create([
            'id' => 0,
            'name' => 'localhost',
            'description' => 'This is a test docker container in development mode',
            'ip' => 'coolify-testing-host',
            'team_id' => 0,
            'private_key_id' => 0,
        ]);

        // Set up proxy status without actually starting it
        // if you just run spin up the proxy wil lstart autmitcally becuase of the server check job (if we seeded the DB once with the new seeder)
        $server->proxy->set('status', 'exited');
        $server->proxy->set('type', ProxyTypes::TRAEFIK->value);
        $server->save();
    }
}
