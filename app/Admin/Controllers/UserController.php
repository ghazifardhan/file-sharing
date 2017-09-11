<?php

namespace App\Admin\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class UserController extends Controller
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
            return Admin::grid(User::class, function (Grid $grid) {
    
                $grid->id('ID')->sortable();
                $grid->column('name')->sortable();
                $grid->column('email')->sortable();
    
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
            return Admin::form(User::class, function (Form $form) {
    
                $form->display('id', 'ID');
                $form->text('name');
                $form->text('email');
                $form->password('password', trans('password'))->rules('required|confirmed');
                $form->password('password_confirmation', trans('password_confirmation'))->rules('required')
                ->default(function ($form) {
                    return $form->model()->password;
                });

                $form->ignore(['password_confirmation']);
    
                $form->display('created_at', 'Created At');
                $form->display('updated_at', 'Updated At');

                $form->saving(function (Form $form) {
                    if ($form->password && $form->model()->password != $form->password) {
                        $form->password = bcrypt($form->password);
                    }
                });
            });
        }
}
