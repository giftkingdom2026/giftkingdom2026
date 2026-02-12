<?php

namespace App\Console\Commands;

use App\Models\Web\Order;

use Illuminate\Console\Command;

class Shipment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shipment:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shipment Status Update';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Order::updateShipment();
    }
}
