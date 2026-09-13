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
            <input type="text" name="title"
                   value="{{ old('title', $category->title) }}" required>
        </label>
        @error('title') <br><small style="color:red">{{ $message }}</small> @enderror
    </p>

    <p>
        <label>Slug<br>
            <input type="text" name="slug"
                   value="{{ old('slug', $category->slug) }}">
        </label>
        @error('slug') <br><small style="color:red">{{ $message }}</small> @enderror
    </p>

    <p>
        <label>Родитель<br>
            <select name="parent_id">
                <option value="">— нет —</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}"
                        @selected(old('parent_id', $category->parent_id) == $cat->id)>
                        {{ $cat->title }}
                    </option>
                @endforeach
            </select>
        </label>
        @error('parent_id') <br><small style="color:red">{{ $message }}</small> @enderror
    </p>

    <p>
        <label>
            <input type="checkbox" name="active" value="1"
                @checked(old('active', $category->active))>
            Активна
        </label>
    </p>

    <button type="submit">Обновить</button>
    <a href="{{ route('admin.categories.index') }}">Отмена</a>
</form>

</body>
</html>
