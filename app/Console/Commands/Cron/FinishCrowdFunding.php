<?php

namespace App\Console\Commands\Cron;

use App\Jobs\RefundCrowdfundingOrders;
use App\Models\CrowdfundingProduct;
use App\Models\Order;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FinishCrowdFunding extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:finish-crowdfunding';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '结束众筹';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        CrowdfundingProduct::query()
            // 众筹结束时间早于当前时间
            ->where('end_at','<=',Carbon::now())
            // 众筹状态为众筹中
            ->where('status',CrowdfundingProduct::STATUS_FUNDING)
            ->get()
            ->each(function(CrowdfundingProduct $crowdfundingProduct){
                // 如果众筹目标金额大于实际众筹金额
                if($crowdfundingProduct->target_amount > $crowdfundingProduct->total_amount){
                    // 调用众筹失败逻辑
                    $this->crowdfundingFailed($crowdfundingProduct);
                }else{
                    // 否则调用众筹成功逻辑
                    $this->crowdfundingSucceed($crowdfundingProduct);
                }
            });
    }
    protected function crowdfundingSucceed(CrowdfundingProduct $crowdfunding)
    {
        // 只需将众筹状态改为众筹成功即可
        $crowdfunding->update([
            'status'=>CrowdfundingProduct::STATUS_SUCCESS,
        ]);
    }
    protected function crowdfundingFailed(CrowdfundingProduct $crowdfunding)
    {
        // 将众筹状态改为众筹失败
        $crowdfunding->update([
            // 订单类型为众筹商品订单
            'status'=>CrowdfundingProduct::STATUS_FAIL,
        ]);
        dispatch(new RefundCrowdfundingOrders($crowdfunding));

    }
}
