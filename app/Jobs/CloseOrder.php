<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
// 代表这个类需要被放到队列中执行，而不是触发时立即执行
class CloseOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order,$delay)
    {
        $this->order = $order;
        //设置延迟时间，dealy() 方法的参数代表多少秒之后执行
        $this->delay($delay);
    }

    // 定义这个任务类具体的执行逻辑
    // 当队列处理器从队列中取出任务时，会调用 handle() 方法
    public function handle()
    {
        if($this->order->paid_at){
            return;
        }
        // 判断对应的订单是否已经被支付
        // 如果已经支付则不需要关闭订单，直接退出
        \DB::transaction(function(){
            //将订单的 closed 字段标记为true,即关闭订单
            $this->order->update(['closed'=>true]);
            //循环遍历订单中的商品 SKU,将订单中的数量加回到 SKU 的库存中去
            foreach ($this->order->items as $item){
                $item->productSku->addStock($item->amount);
            }
            if($this->order->couponCode){
                $this->order->couponCode()->changeUsed(false);
            };
        });
    }
}
