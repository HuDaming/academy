<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Models\Store;

use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class StoreController extends Controller
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

            if (Admin::user()->roles[0]->slug == 'store') {
                $content->header('商铺');
                $content->description('基本资料');

                $store = Store::find(1);
                $content->row($store->name);
            } else {
                $content->header('商铺');
                $content->description('列表');

                $content->body($this->grid());
            }
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

            $content->header('商铺');
            $content->description('创建');

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
        return Admin::grid(Store::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->column('name', '商铺名称');

            $grid->column('logo', 'LOGO')->display(function ($logo) {
                return '<img src="' . asset('upload/' . $logo) . '" width=90 height=90 alt="logo" />';
            });

            $grid->column('introduce', '简介');

            $grid->column('created_at', '创建时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Store::class, function (Form $form) {

            $form->display('id', 'ID');

//            $form->select('type_id', '商铺分类')->options(Category::where('parent_id', 0)->pluck('name', 'id'));
            $form->text('name', '商铺名称');
            $form->image('logo', '商铺LOGO');
            $form->textarea('introduce', '简介');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
