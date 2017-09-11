<?php

namespace App\Admin\Controllers;

use App\Models\UploadMedia;
use App\Models\User;
use App\Models\Group;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class UploadMediaController extends Controller
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

            $content->header('header');
            $content->description('description');

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
        return Admin::grid(UploadMedia::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->created_at();
            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(UploadMedia::class, function (Form $form) {

            $form->display('id', 'ID');

            $users = User::all();
            foreach($users as $key => $val){
                $user[$users[$key]['id']] = $users[$key]['name'];
            }

            $groups = Group::all();
            foreach($groups as $key => $val){
                $group[$groups[$key]['id']] = $groups[$key]['group_name'];
            }

            $form->select('group_id', 'Group')->options($group);
            $form->select('user_id', 'User')->options($user);

            $form->file("file_path");
            
            $form->text('media_name');
            $form->text('media_type');
            $form->text('file_location');

            $flag = [
                0 => 'Personal',
                1 => 'Group'
            ];

            $form->select('flag', 'Flag')->options($flag);

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
