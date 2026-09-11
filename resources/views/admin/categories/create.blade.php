<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Создать категорию</title>
</head>
<body>
<h1>Создать категорию</h1>

<form action="{{ route('admin.categories.store') }}" method="POST">
    @csrf

    <p>
        <label>Название *<br>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </label>
        @error('name') <br><small style="color:red">{{ $message }}</small> @enderror
    </p>

    <p>
        <label>Slug<br>
            <input type="text" name="slug" value="{{ old('slug') }}">
        </label>
        @error('slug') <br><small style="color:red">{{ $message }}</small> @enderror
    </p>

    <p>
        <label>Описание<br>
            <textarea name="description">{{ old('description') }}</textarea>
        </label>
        @error('description') <br><small style="color:red">{{ $message }}</small> @enderror
    </p>

    <button type="submit">Сохранить</button>
    <a href="{{ route('admin.categories.index') }}">Отмена</a>
</form>
</body>
</html>
