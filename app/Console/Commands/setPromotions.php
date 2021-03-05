<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Promotion;
use Carbon\Carbon;
use DB;

class setPromotions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'promotion:unset';

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
     * @return mixed
     */
    public function handle()
    {
        $today = Carbon::now()->format('Y-m-d');
        # get expired promotions
        $endedPromotions = Promotion::where('end', '<=', $today)->pluck('id');
        # sync the product promotion
        Promotion::whereIn('id', $endedPromotions)->delete();
        DB::table('promotion_product')->whereIn('promotion_id', $endedPromotions)->delete();
    }
}
