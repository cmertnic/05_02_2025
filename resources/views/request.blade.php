@extends('layouts.main')

@section('content')
    <x-guest-layout>
        <div class="flex ">
            <!-- Общее сообщение об ошибке -->
            @if ($errors->any())
                <div class="mb-4 text-red-600">
                    <strong>Произошла ошибка при регистрации:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (\App\Models\Work::where('user_id', $user->id)->exists())
                <div class="text-center text-blue-500/100 mb-10 text-4xl">
                    Вы уже отправили работу. Желаем удачи!
                </div>
            @else
                <form method="POST" action="{{ route('request.store') }}" enctype="multipart/form-data" class="w-full max-w-lg">
                    @csrf
                    <h1 class="text-center text-blue-500/100 mb-10 text-4xl">Создание заявки</h1>

                    <!-- Category Selection -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700">Категория</label>
                        <select id="category" name="category_id" class="block mt-1 w-full" required>
                            <option value="" disabled selected>Выберите категорию</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <!-- Title Input -->
                    <div class="mt-4">
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required placeholder="Название открытки" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Image Upload Input -->
                    <div class="mt-4 flex items-center justify-center">
                        <label for="path_img" class="block text-sm font-medium text-gray-700">Загрузите изображение</label>
                        <x-text-input id="path_img" class="block mt-1 w-full" type="file" name="path_img" accept="image/*" required />
                        <x-input-error :messages="$errors->get('path_img')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-center mt-4">
                        <x-primary-button class="ms-4">
                            {{ __('Создать заявку') }}
                        </x-primary-button>
                    </div>

                    <!-- Logout Button -->
                    <div class="mt-4 flex items-center justify-center">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-primary-button class="ms-4" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Выйти') }}
                            </x-primary-button>
                        </form>
                    </div>
                </form>
            @endif
        </div>
    </x-guest-layout>
@endsection

