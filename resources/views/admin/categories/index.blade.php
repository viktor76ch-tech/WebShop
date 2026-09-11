<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Категории</title>
</head>
<body>
<h1>Категории</h1>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<a href="{{ route('admin.categories.create') }}">+ Создать категорию</a>

<table border="1" cellpadding="8" cellspacing="0" style="margin-top: 15px">
    <thead>
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Slug</th>
        <th>Описание</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>
    @forelse($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->slug }}</td>
            <td>{{ $category->description }}</td>
            <td>
                <a href="{{ route('admin.categories.edit', $category) }}">Редактировать</a>
            </td>
        </tr>
    @empty
        <tr><td colspan="5">Категорий пока нет</td></tr>
    @endforelse
    </tbody>
</table>

<div style="margin-top: 15px">
    {{ $categories->links() }}
</div>
</body>
</html>
