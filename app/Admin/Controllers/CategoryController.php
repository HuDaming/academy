<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Encore\Admin\Form;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Tree;
use Encore\Admin\Widgets\Box;

class CategoryController extends Controller
{
    use ModelForm;

    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('商品分类');
            $content->description('列表');

            $content->row(function (Row $row) {
                $row->column(6, $this->treeView()->render());

                $row->column(6, function (Column $column) {
                    $form = new \Encore\Admin\Widgets\Form();
                    $form->action(admin_url('categories'));

                    $form->select('parent_id', '父级分类')->options(Category::selectOptions());
                    $form->text('title', trans('admin::lang.title'))->rules('required');
                    $form->icon('icon', trans('admin::lang.icon'))->default('fa-bars')->rules('required')->help($this->iconHelp());

                    $column->append((new Box(trans('admin::lang.new'), $form))->style('success'));
                });
            });


        });
    }

    public function show($id)
    {
        return redirect()->action(
            '\App\Admin\Controllers\CategoryController@edit', ['id' => $id]
        );
    }

    protected function treeView()
    {
        return Category::tree(function (Tree $tree) {
            $tree->disableCreate();

            $tree->branch(function ($branch) {
                $payload = "<i class='fa {$branch['icon']}'></i>&nbsp;<strong>{$branch['title']}</strong>";

                return $payload;
            });
        });
    }

    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header(trans('admin::lang.menu'));
            $content->description(trans('admin::lang.edit'));

            $content->row($this->form()->edit($id));
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {
        return Category::form(function (Form $form) {
            $form->display('id', 'ID');

            $form->select('parent_id', trans('admin::lang.parent_id'))->options(Category::selectOptions());
            $form->text('title', trans('admin::lang.title'))->rules('required');
            $form->icon('icon', trans('admin::lang.icon'))->default('fa-bars')->rules('required')->help($this->iconHelp());

            $form->display('created_at', trans('admin::lang.created_at'));
            $form->display('updated_at', trans('admin::lang.updated_at'));
        });
    }

    /**
     * Help message for icon field.
     *
     * @return string
     */
    protected function iconHelp()
    {
        return 'For more icons please see <a href="http://fontawesome.io/icons/" target="_blank">http://fontawesome.io/icons/</a>';
    }
}
