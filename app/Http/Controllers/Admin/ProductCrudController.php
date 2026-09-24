<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('product', 'products');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('image')
            ->type('text')
            ->label('Фото')
            ->limit(30);

        CRUD::column('name')
            ->type('text')
            ->label('Название');

        CRUD::column('category')
            ->type('select')
            ->label('Категория')
            ->entity('category')
            ->model(\App\Models\Category::class)
            ->attribute('title');

        CRUD::column('price')
            ->type('number')
            ->label('Цена')
            ->prefix('₽')
            ->decimals(2);

        CRUD::column('stock')
            ->type('number')
            ->label('На складе');

        CRUD::column('active')
            ->type('check')
            ->label('Активен');
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
            'name'        => 'required|min:2|max:255',
            'slug'        => 'required|min:2|max:255|unique:products,slug',
            'category_id' => 'nullable|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'active'      => 'boolean',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        CRUD::field('name')
            ->type('text')
            ->label('Название')
            ->attributes(['placeholder' => 'Например, iPhone 15 Pro']);

        CRUD::field('slug')
            ->type('text')
            ->label('Slug (URL)')
            ->hint('Латиницей, без пробелов. Например: iphone-15-pro');

        CRUD::field('category_id')
            ->type('select')
            ->label('Категория')
            ->entity('category')
            ->model(\App\Models\Category::class)
            ->attribute('title')
            ->options(function ($query) {
                return $query->orderBy('title')->get();
            })
            ->allow_null(true);

        CRUD::field('description')
            ->type('textarea')
            ->label('Описание')
            ->attributes(['rows' => 4]);

        CRUD::field('price')
            ->type('number')
            ->label('Цена (₽)')
            ->attributes(['step' => '0.01', 'min' => '0']);

        CRUD::field('stock')
            ->type('number')
            ->label('Количество на складе')
            ->default(0)
            ->attributes(['min' => '0']);

        CRUD::field('image')
            ->type('upload')
            ->label('Фото товара')
            ->withFiles([
                'disk' => 'public',
                'path' => 'uploads/products',
            ])
            ->hint('JPG, PNG, WEBP. Максимум 2 МБ.');

        CRUD::field('active')
            ->type('checkbox')
            ->label('Активен')
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
