<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Категории</title>
    <style>
        table { border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 8px; }
        .alert-success { color: green; }
        .alert-error   { color: red; }
        .btn-delete    { color: red; background: none; border: none; cursor: pointer; padding: 0; }
    </style>
</head>
<body>

<h1>Категории</h1>

@if(session('success'))
    <p class="alert-success">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p class="alert-error">{{ session('error') }}</p>
@endif

<a href="{{ route('admin.categories.create') }}">+ Создать категорию</a>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Slug</th>
        <th>Родитель</th>
        <th>Активна</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>
    @forelse($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->title }}</td>
            <td>{{ $category->slug }}</td>
            <td>{{ $category->parent?->title ?? '—' }}</td>
            <td>{{ $category->active ? 'Да' : 'Нет' }}</td>
            <td>
                <a href="{{ route('admin.categories.edit', $category) }}">Редактировать</a>

                <form action="{{ route('admin.categories.destroy', $category) }}"
                      method="POST"
                      style="display:inline"
                      onsubmit="return confirm('Удалить категорию «{{ $category->title }}»?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">Удалить</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6">Категорий пока нет</td>
        </tr>
    @endforelse
    </tbody>
</table>

<div style="margin-top: 15px">
    {{ $categories->links() }}
</div>

</body>
</html>
