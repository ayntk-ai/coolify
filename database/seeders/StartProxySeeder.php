<?php

namespace Database\Seeders;

use App\Models\Server;
use App\Actions\Proxy\StartProxy;
use Illuminate\Database\Seeder;
use App\Events\ProxyStatusChanged;

class StartProxySeeder extends Seeder
{
    public function run(): void
    {
        $server = Server::find(0); // Assuming the server ID is 0 as in ServerSeeder

        if ($server) {
            // This starts the proxy but it does not wait for it to finish starting (it is instat though) 
            // If we want to wait for the proxy we would have to add something like this: StartProxy::run($server, async: false, force: true);
            // Also if the proxy is running it will remove it and start a new one.
            // WHEN RUNNING SPIN UP THE SEEDERS SHOULD ALSO BE RUN??
            $server->proxy->force_stop = false;
            $server->save();
            $activity = StartProxy::run($server, force: true);
            dispatch('activityMonitor', $activity->id, ProxyStatusChanged::class);
        }
    }
}