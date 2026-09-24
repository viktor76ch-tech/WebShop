<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('пользователя', 'пользователи');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('id')
            ->type('number')
            ->label('ID');

        CRUD::column('avatar')
            ->type('image')
            ->label('Аватар')
            ->height('40px')
            ->width('40px')
            ->fallback(['https://ui-avatars.com/api/?name=User']);

        CRUD::column('name')
            ->type('text')
            ->label('Имя');

        CRUD::column('email')
            ->type('email')
            ->label('Email');

        CRUD::column('created_at')
            ->type('datetime')
            ->label('Зарегистрирован');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation([
            'name'     => 'required|min:2|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        CRUD::field('name')
            ->type('text')
            ->label('Имя');

        CRUD::field('email')
            ->type('email')
            ->label('Email');

        CRUD::field('password')
            ->type('password')
            ->label('Пароль')
            ->hint('Минимум 8 символов');

        CRUD::field('avatar')
            ->type('upload')
            ->label('Аватар')
            ->withFiles([
                'disk' => 'public',
                'path' => 'avatars',
            ])
            ->hint('JPG, PNG, WEBP. Максимум 2 МБ.');
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        CRUD::setValidation([
            'name'     => 'required|min:2|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . CRUD::getCurrentEntryId(),
            'password' => 'nullable|min:8',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        CRUD::field('name')
            ->type('text')
            ->label('Имя');

        CRUD::field('email')
            ->type('email')
            ->label('Email');

        CRUD::field('password')
            ->type('password')
            ->label('Новый пароль')
            ->hint('Оставь пустым, чтобы не менять. Минимум 8 символов.');

        CRUD::field('avatar')
            ->type('upload')
            ->label('Аватар')
            ->withFiles([
                'disk' => 'public',
                'path' => 'avatars',
            ])
            ->hint('JPG, PNG, WEBP. Максимум 2 МБ.');
    }

    public function destroy($id)
    {
        if ((int) $id === backpack_user()->id) {
            return response()->json([
                'error' => 'Вы не можете удалить свой собственный аккаунт.',
            ], 403);
        }

        return $this->crud->delete($id);
    }
}
