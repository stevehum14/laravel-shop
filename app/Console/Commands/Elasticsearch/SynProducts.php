<?php

namespace App\Console\Commands\Elasticsearch;

use App\Models\Product;
use Illuminate\Console\Command;

class SynProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:sync-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '将商品数据同步到 Elasticsearch';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // 获取 Elasticsearch 对象
        $es = app('es');
        Product::query()
            ->with(['skus','properties'])
            ->chunkById(100,function($products) use ($es){
                $this->info(sprintf('正在同步 ID 范围为 %s 至 %s 的商品', $products->first()->id, $products->last()->id));
                $req = ['body'=>[]];
                foreach ($products as $product){
                    $data = $product->toESArray();
                    $req['body'][] =[
                        'index'=>[
                            '_index'=>'products',
                            '_id'=>$data['id'],
                        ]
                    ];
                    $req['body'][] = $data;
                }
                try{
                    $es->bulk($req);
                }catch (\Exception $e){
                    $this->error($e->getMessage());
                }
            });
        $this->info('同步完成');
    }
}
