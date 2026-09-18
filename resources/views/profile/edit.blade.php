@extends('layouts.main')

@section('content')
    <div class="container" style="max-width: 600px; margin: 30px auto;">
        <h1>Профиль</h1>

        @if (session('status'))
            <div style="padding: 10px; background: #d1fae5; margin-bottom: 15px; border-radius: 4px;">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Аватарка --}}
            <div style="margin-bottom: 15px;">
                <img src="{{ $user->avatar_url }}" alt="avatar"
                     style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; display: block; margin-bottom: 10px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="avatar">Новая аватарка</label>
                <input type="file" name="avatar" id="avatar">
                @error('avatar') <div style="color: red;">{{ $message }}</div> @enderror
            </div>

            {{-- Имя --}}
            <div style="margin-bottom: 15px;">
                <label for="name">Имя</label><br>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
                @error('name') <div style="color: red;">{{ $message }}</div> @enderror
            </div>

            {{-- Email --}}
            <div style="margin-bottom: 15px;">
                <label for="email">Email</label><br>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
                @error('email') <div style="color: red;">{{ $message }}</div> @enderror
            </div>

            <hr>
            <h3>Смена пароля</h3>
            <p style="color: #666;">Оставь пустым, если не меняешь.</p>

            <div style="margin-bottom: 15px;">
                <label for="current_password">Текущий пароль</label><br>
                <input type="password" name="current_password" id="current_password">
                @error('current_password') <div style="color: red;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom: 15px;">
                <label for="password">Новый пароль</label><br>
                <input type="password" name="password" id="password">
                @error('password') <div style="color: red;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom: 15px;">
                <label for="password_confirmation">Подтверждение пароля</label><br>
                <input type="password" name="password_confirmation" id="password_confirmation">
            </div>

            <button type="submit">Сохранить</button>
        </form>

        @if ($user->avatar)
            <form action="{{ route('profile.avatar.destroy') }}" method="POST" style="margin-top: 15px;"
                  onsubmit="return confirm('Удалить аватарку?')">
                @csrf
                @method('DELETE')
                <button type="submit">Удалить аватарку</button>
            </form>
        @endif

        {{-- ===== Удаление аккаунта ===== --}}
        <hr class="my-5">

        <h3 class="text-danger">Удаление аккаунта</h3>
        <p style="color: #666;">Это действие необратимо. Все ваши данные будут удалены.</p>

        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
            <i class="fas fa-trash-alt me-1"></i> Удалить аккаунт
        </button>

        {{-- Модальное окно --}}
        <div class="modal fade" id="deleteAccountModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form method="POST" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title text-danger">Удалить аккаунт?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-3">
                                Это действие <strong>необратимо</strong>. Введите пароль для подтверждения.
                            </p>
                            <input type="password"
                                   class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                                   name="password" placeholder="Введите пароль" required>
                            @error('password', 'userDeletion')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash-alt me-1"></i>Удалить навсегда
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Автооткрытие модалки, если при удалении была ошибка --}}
    @if ($errors->userDeletion->isNotEmpty())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var deleteModal = new bootstrap.Modal(document.getElementById('deleteAccountModal'));
                deleteModal.show();
            });
        </script>
    @endif
@endsection
