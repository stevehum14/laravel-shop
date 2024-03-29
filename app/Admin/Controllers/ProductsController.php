<?php

namespace App\Admin\Controllers;

use App\Models\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ProductsController extends CommonProductsController
{
    public function getProductType()
    {
        return Product::TYPE_NORMAL;
    }
    protected function customGrid(Grid $grid)
    {
        $grid->model()->with(['category']);
        $grid->id('ID')->sortable();
        $grid->title('商品名称');
        $grid->column('category.name', '类目');
        $grid->on_sale('已上架')->display(function ($value) {
            return $value ? '是' : '否';
        });
        $grid->price('价格');
        $grid->rating('评分');
        $grid->sold_count('销量');
        $grid->review_count('评论数');
    }
    protected function customForm(Form $form)
    {
        // 普通商品没有额外的字段，因此这里不需要写任何代码
    }
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商品';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
//    protected function grid()
//    {
//        $grid = new Grid(new Product());
//        $grid->model()->where('type', Product::TYPE_NORMAL)->with(['category']);
//
//        $grid->id('ID')->sortable();
//        $grid->title('商品名称');
//        // Laravel-Admin 支持用符号 . 来展示关联关系的字段
//        $grid->column('category.name', '类目');
//        $grid->on_sale('已上架')->display(function ($value) {
//            return $value ? '是' : '否';
//        });
//        $grid->price('价格');
//        $grid->rating('评分');
//        $grid->sold_count('销量');
//        $grid->review_count('评论数');
//
//        $grid->actions(function ($actions) {
//            $actions->disableView();
//            $actions->disableDelete();
//        });
//        $grid->tools(function ($tools) {
//            // 禁用批量删除按钮
//            $tools->batch(function ($batch) {
//                $batch->disableDelete();
//            });
//        });
//
//        return $grid;
//    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
//    protected function form()
//    {
//        $form = new Form(new Product());
//        // 在表单中添加一个名为 type，值为 Product::TYPE_NORMAL 的隐藏字段
//        $form->hidden('type')->value(Product::TYPE_NORMAL);
//        // 创建一个输入框，第一个参数 title 是模型的字段名，第二个参数是该字段描述
//        $form->text('title', '商品名称')->rules('required');
//        // 添加一个类目字段，与之前类目管理类似，使用 Ajax 的方式来搜索添加
//        $form->select('category_id', '类目')->options(function ($id) {
//            $category = Category::find($id);
//            if ($category) {
//                return [$category->id => $category->full_name];
//            }
//        })->ajax('/admin/api/categories?is_directory=0');
//
//        // 创建一个选择图片的框
//        $form->image('image', '封面图片')->rules('required|image');
//        // 创建一个富文本编辑器
//        $form->quill('description', '商品描述')->rules('required');
//
//        // 创建一组单选框
//        $form->radio('on_sale', '上架')->options(['1' => '是', '0'=> '否'])->default('0');
//
//        // 直接添加一对多的关联模型
//        $form->hasMany('skus','SKU 列表',function(Form\NestedForm $form){
//            $form->text('title', 'SKU 名称')->rules('required');
//            $form->text('description', 'SKU 描述')->rules('required');
//            $form->text('price', '单价')->rules('required|numeric|min:0.01');
//            $form->text('stock', '剩余库存')->rules('required|integer|min:0');
//        });
//        // 定义事件回调，当模型即将保存时会触发这个回调
//        $form->saving(function (Form $form) {
//            $form->model()->price = collect($form->input('skus'))->where(Form::REMOVE_FLAG_NAME, 0)->min('price') ?: 0;
//        });
//        return $form;
//    }
}
