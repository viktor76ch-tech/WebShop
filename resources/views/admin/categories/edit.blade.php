<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать категорию</title>
</head>
<body>
<h1>Редактировать категорию</h1>

<form action="{{ route('admin.categories.update', $category) }}" method="POST">
    @csrf
    @method('PUT')

    <p>
        <label>Название *<br>
            <input type="text" name="name"
                   value="{{ old('name', $category->name) }}" required>
        </label>
        @error('name') <br><small style="color:red">{{ $message }}</small> @enderror
    </p>

    <p>
        <label>Slug<br>
            <input type="text" name="slug"
                   value="{{ old('slug', $category->slug) }}">
        </label>
        @error('slug') <br><small style="color:red">{{ $message }}</small> @enderror
    </p>

    <p>
        <label>Описание<br>
            <textarea name="description">{{ old('description', $category->description) }}</textarea>
        </label>
        @error('description') <br><small style="color:red">{{ $message }}</small> @enderror
    </p>

    <button type="submit">Обновить</button>
    <a href="{{ route('admin.categories.index') }}">Отмена</a>
</form>
</body>
</html>
