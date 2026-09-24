<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CategoryCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Category::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/category');
        CRUD::setEntityNameStrings('category', 'categories');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // Parent — вместо ID показываем title родителя
        CRUD::column('parent')
            ->type('select')
            ->label('Родитель')
            ->entity('parent')      // связь parent() в модели Category
            ->model(\App\Models\Category::class)
            ->attribute('title')
            ->wrapper([
                'href' => function ($crud, $column, $entry) {
                    if (!$entry->parent) {
                        return false;
                    }
                    return backpack_url('category/' . $entry->parent_id . '/show');
                },
            ]);

        CRUD::column('title')
            ->type('text')
            ->label('Название');

        CRUD::column('slug')
            ->type('text')
            ->label('Slug');

        CRUD::column('active')
            ->type('check')
            ->label('Активна');
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
            'title'     => 'required|min:2|max:255',
            'slug'      => 'required|min:2|max:255|unique:categories,slug',
            'parent_id' => 'nullable|exists:categories,id',
            'active'    => 'boolean',
        ]);

        CRUD::field('title')
            ->type('text')
            ->label('Название')
            ->attributes(['placeholder' => 'Например, Смартфоны']);

        CRUD::field('slug')
            ->type('text')
            ->label('Slug (URL)')
            ->hint('Латиницей, без пробелов. Например: smartphones');

        CRUD::field('parent_id')
            ->type('select')
            ->label('Родительская категория')
            ->entity('parent')
            ->model(\App\Models\Category::class)
            ->attribute('title')
            ->options(function ($query) {
                // Чтобы категория не могла стать родителем сама себе
                return $query->whereNull('parent_id')->orderBy('title')->get();
            })
            ->allow_null(true)
            ->hint('Оставь пустым, если это категория верхнего уровня');

        CRUD::field('active')
            ->type('checkbox')
            ->label('Активна')
            ->default(1);
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
