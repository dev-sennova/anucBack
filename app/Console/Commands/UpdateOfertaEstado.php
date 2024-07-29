<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tb_oferta;
use Carbon\Carbon;

class UpdateOfertaEstado extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update_estado';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $today = Carbon::today();
        Tb_oferta::where('end_date', '<', $today)
        ->where('estado', '!=', 0)
        ->update(['estado' => 0]);
        $this->info('Ofertas expiradas actualizadas correctamente.');
    }
}
