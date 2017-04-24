<?php

namespace App\Admin\Controllers;

use App\Models\AdminUser;
use App\Models\Goods;

use App\Models\Store;
use App\Models\Type;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class GoodsController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('商品');
            $content->description('列表');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Goods::class, function (Grid $grid) {

            if (Admin::user()->roles[0]->slug == 'store') {
                //获取用户店铺ID
                $user = AdminUser::with('store')->find(Admin::user()->id);
                $grid->model()->where('store_id', $user->store[0]->id);
            }


            $grid->disableExport();
            $grid->id('ID')->sortable();

            $grid->column('name', '商品名称');
            $grid->column('cover', '展示图')->display(function ($cover) {
                return '<img src="' . asset('uploads/' . $cover) . '" width=90 height=90 alt="logo" />';
            });
            $grid->column('store_id', '商铺')->display(function ($store_id) {
                return Store::find($store_id)->name;
            });
            $grid->column('class_id', '分类')->display(function ($class_id) {
                return Type::find($class_id)->name;
            });
            $grid->column('description', '简介');

            $grid->column('created_at', '发布时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Goods::class, function (Form $form) {

            $form->hidden('store_id')->value(1);
            $form->hidden('user_id')->value(Admin::user()->id);

            $form->tab('基本信息', function ($form) {
                $form->text('name', '商品名称');
                $form->select('class_id', '分类')->options(Type::all()->pluck('name', 'id'));
                $form->image('cover', '展示图');
                $form->textarea('description', '简介');
                $form->multipleImage('attach', '图组附件');
                $form->currency('price', '单价')->symbol('￥');
                $form->dateRange('startTime', 'overTime', '限时购买');

                $states = [
                    'on'  => ['value' => 1, 'text' => '上架', 'color' => 'success'],
                    'off' => ['value' => 0, 'text' => '下架', 'color' => 'danger'],
                ];
                $form->switch('on', '是否上架')->states($states);

            })->tab('属性', function ($form) {
                $form->select('type', '期刊类型')->options([1 => '周刊', 2 => '半月刊', 3 => '月刊', 4 => '季刊']);
                $form->date('year', '期刊年')->format('YYYY');
                $form->multipleSelect('month', '期刊月')->options([1 => '1月', 2 => '2月',3 => '3月', 4 => '4月',5 => '5月', 6 => '6月',7 => '7月', 8 => '8月',9 => '9月', 10 => '10月',11 => '11月', 12 => '12月',]);
                $form->multipleSelect('classes', '适读年级')->options([1 => '一年级', 2 => '二年级', 3 => '三年级', 4 => '四年级', 5 => '五年级', 6 => '六年级' ]);

            })->tab('详情', function ($form) {
                $form->editor('content', '详情');
            });

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
