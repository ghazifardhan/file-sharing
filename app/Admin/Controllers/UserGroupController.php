<?php

namespace App\Admin\Controllers;

use App\Models\UserGroup;
use App\Models\Group;
use App\Models\User;
use App\Models\Role;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class UserGroupController extends Controller
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
        return Admin::grid(UserGroup::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('group_id')->sortable();
            $grid->column('group.group_name')->sortable();
            $grid->column('user_id')->sortable();
            $grid->column('user.name')->sortable();

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
        return Admin::form(UserGroup::class, function (Form $form) {

            $form->display('id', 'ID');
            
            $users = User::all();
            foreach($users as $key => $val){
                $user[$users[$key]['id']] = $users[$key]['name'];
            }

            $groups = Group::all();
            foreach($groups as $key => $val){
                $group[$groups[$key]['id']] = $groups[$key]['group_name'];
            }

            $roles = Role::all();
            foreach($roles as $key => $val){
                $role[$roles[$key]['id']] = $roles[$key]['role'];
            }

            $form->select('group_id', 'Group')->options($group);
            $form->select('user_id', 'User')->options($user);
            $form->select('role_id', 'Role')->options($role);


            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
