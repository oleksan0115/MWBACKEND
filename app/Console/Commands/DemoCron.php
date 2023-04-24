<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\MwProduct;
use DB;
class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:corn';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
	     $current_datetime_on_server = date("Y-m-d H:i");
       

         
       DB::table('tbl_mw_products')->where('active_datetime', $current_datetime_on_server)->update(['status' => 1]);
        // return Command::SUCCESS;
    }
}
