<?php

namespace App\Admin\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Http\Requests\Admin\HandleRefundRequest;
use App\Http\Requests\Request;
use App\Models\CrowdfundingProduct;
use App\Models\Order;
use App\Services\OrderService;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Foundation\Validation\ValidatesRequests;

class OrdersController extends AdminController
{
    use ValidatesRequests;
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '订单';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order());
        //只展示已支付的订单，并且默认按支付时间倒序排序
        $grid->model()->whereNotNull('paid_at')->orderBy('paid_at','desc');
        $grid->no('订单流水号');
        // 展示关联关系的字段时，使用 column 方法
        $grid->column('user.name','买家');
        $grid->total_amount('总金额')->sortable();
        $grid->paid_at('支付时间')->sortable();
        $grid->ship_status('物流')->display(function($value){
            return Order::$shipStatusMap[$value];
        });
        $grid->refund_status('退款状态')->display(function($value){
            return Order::$refundStatusMap[$value];
        });
        // 禁用创建按钮，后台不需要创建订单
        $grid->disableCreateButton();
        $grid->actions(function($actions){
            // 禁用删除和编辑按钮
            $actions->disableDelete();
            $actions->disableEdit();
        });
        $grid->tools(function ($tools){
            // 禁用批量删除按钮
            $tools->batch(function($batch){
                $batch->disableDelete();
            });
        });
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
//    protected function detail($id)
//    {
//        $show = new Show(Order::findOrFail($id));
//
//        $show->field('id', __('Id'));
//        $show->field('no', __('No'));
//        $show->field('user_id', __('User id'));
//        $show->field('address', __('Address'));
//        $show->field('total_amount', __('Total amount'));
//        $show->field('remark', __('Remark'));
//        $show->field('paid_at', __('Paid at'));
//        $show->field('payment_method', __('Payment method'));
//        $show->field('payment_no', __('Payment no'));
//        $show->field('refund_status', __('Refund status'));
//        $show->field('refund_no', __('Refund no'));
//        $show->field('closed', __('Closed'));
//        $show->field('reviewed', __('Reviewed'));
//        $show->field('ship_status', __('Ship status'));
//        $show->field('ship_data', __('Ship data'));
//        $show->field('extra', __('Extra'));
//        $show->field('created_at', __('Created at'));
//        $show->field('updated_at', __('Updated at'));
//        return $show;
//    }
    public function show($id,Content $content)
    {
        return $content
            ->header('查看订单')
            ->body(view('admin.orders.show',['order'=>Order::find($id)]));
    }

    public function ship(Order $order,Request $request)
    {
        // 判断当前订单是否已支付
        if(!$order->paid_at){
            throw new InvalidRequestException('该订单未付款');
        }
        // 判断当前订单发货状态是否为未发货
        if($order->ship_status != Order::SHIP_STATUS_PENDING){
            throw new InvalidRequestException('该订单已发货');
        }
        // 众筹订单只有在众筹成功之后发货
        if ($order->type === Order::TYPE_CROWDFUNDING &&
            $order->items[0]->product->crowdfunding->status !== CrowdfundingProduct::STATUS_SUCCESS) {
            throw new InvalidRequestException('众筹订单只能在众筹成功之后发货');
        }
        // Laravel 5.5 之后 validate 方法可以返回校验过的值
        $data = $this->validate($request, [
            'express_company' => ['required'],
            'express_no'      => ['required'],
        ], [], [
            'express_company' => '物流公司',
            'express_no'      => '物流单号',
        ]);
        // 将订单发货状态改为已发货，并存入物流信息
        $order->update([
            'ship_status'=>Order::SHIP_STATUS_DELIVERED,
            // 我们在 Order 模型的 $casts 属性里指明了 ship_data 是一个数组
            // 因此这里可以直接把数组传过去
            'ship_data'=>$data,
        ]);
        //返回上一页
        return redirect()->back();
    }

    public function handleRefund(Order $order,HandleRefundRequest $request,OrderService $orderService)
    {
        // 判断订单状态是否正确
        if($order->refund_status !== Order::REFUND_STATUS_APPLIED)
        {
            throw new InvalidRequestException('订单状态不正确');
        }
        // 是否同意退款
        if($request->input('agree')){
            // 清空拒绝退款理由
            $extra = $order->extra ?:[];
            unset($extra['refund_disagree_reason']);
            $order->update([
                'extra'=>$extra,
            ]);
            // 调用退款逻辑
//            $this->_refundOrder($order);
            $orderService->refundOrder($order);
        }else{
            // 将拒绝退款理由放到订单的 extra 字段中
            $extra = $order->extra ? : [] ;
            $extra['refund_disagree_reason'] = $request->input('reason');
        }
        // 将订单的退款状态改为未退款
        $order->update([
            'refund_status'=>Order::REFUND_STATUS_PENDING,
            'extra'=>$extra
        ]);
        return $order;
    }

//    protected function _refundOrder(Order $order)
//    {
//        // 判断该订单的支付方式
//        switch ($order->payment_method){
//            case 'wechat':
//                //生成退款订单号
//                $refundNo = Order::getAvailableRefundNo();
//                app('wechat_pay')->refund([
//                    'out_trade_no'=>$order->no, //之前的订单流水号
//                    'total_fee'=>$order->total_amount * 100, //原订单金额，单位分
//                    'refund_fee'=>$order->total_amount * 100, // 要退款的订单号，单位分
//                    'out_refund_no'=>$order->$refundNo, //退款订单号
//                    // 微信支付的退款结果并不是实时返回的，而是通过退款回调来通知，因此这里需要配上退款回调接口地址
//                    //'notify_url'=>'http://requestbin.fullcontact.com/******'// 由于是开发环境，需要配成 requestbin 地址
//                    'notify_url' => route('payment.wechat.refund_notify'),
//                ]);
//                //将订单状态改成退款中
//                $order->update([
//                    'refund_no'=>$refundNo,
//                    'refund_status'=>Order::REFUND_STATUS_PROCESSING
//                ]);
//                break;
//            case 'alipay':
//                // 用我们刚刚写的方法来生成一个退款订单号
//                $refundNo = Order::getAvailableRefundNo();
//                //调用支付宝实例的 refund 方法
//            $ret = app('alipay')->refund([
//                'out_trade_no'=>$order->no, //之前的订单流水号
//                'refund_amount'=>$order->total_amount, // 退款金额，单位元
//                'out_request_no'=>$refundNo, // 退款订单号
//            ]);
//            // 根据支付宝的文档，如果返回值里有 sub_code 字段说明退款失败
//            if ($ret->sub_code){
//                // 将退款失败的保存入 extra 字段
//                $extra = $order->extra;
//                $extra['refund_failed_code'] = $ret->sub_code;
//                // 将订单的退款状态标记为退款失败
//                $order->update([
//                    'refund_no'=>$refundNo,
//                    'refund_status'=>Order::REFUND_STATUS_FAILED,
//                    'extra'=>$extra
//                ]);
//            }else{
//                // 将订单的退款状态标记为退款成功并保存退款订单号
//                $order->update([
//                    'refund_no'=>$refundNo,
//                    'refund_status'=>Order::REFUND_STATUS_SUCCESS
//                ]);
//            }
//            break;
//            default:
//                // 原则上不可能出现，这个只是为了代码健壮性
//                throw new InvalidRequestException('未知订单支付方式：'.$order->payment_method);
//                break;
//        }
//    }
}
