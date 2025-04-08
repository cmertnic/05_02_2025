@extends('layouts.main')

@section('content')
    <div class="flex justify-center items-center bg-gray-100 flex-col">
        <p class="text-center mt-10">Приглашаем Вас принять участие конкурсе новогодних открыток. <br>
            Присылайте рисунки на заданную тему.
        </p>
        <h2 class="font-bold text-2xl mt-5">Правила участия:</h2>
        <ol class="text-center mt-5">
            <li>Ребенок может выслать на конкурс только одну работу. </li>
            <li>Работы, в соответствующих категорией, должны быть выполнены детьми самостоятельно и индивидуально.</li>
            <li>Стиль всегда остаются на усмотрение участника.</li>
        </ol>
        <h2 class="font-bold text-2xl mt-5">Номинациии:</h2>
        <ol class="text-center mt-5">
            <li>рисунок</li>
            <li>акварель</li>
            <li>гуашь</li>
            <li>другое </li>
        </ol>
        <h2 class="font-bold text-2xl mt-5">К участию в конкурсе допускаются:</h2>
        <ol class="text-center mt-5">
            <li>Ученики 1-11 классов школ, лицеев, гимназий, колледжей и любых других образовательных учреждений без
                предварительного отбора. </li>
        </ol>
        <h2 class="font-bold text-2xl mt-5">Требования к работам:</h2>
        <ol class="text-center">
            <li></li>соответствие содержания творческой работы заявленной тематике
            <li>актуальность конкурсной работы</li>
            <li>творческая индивидуальность</li>
            <li>оригинальность идеи, новаторство, творческий подход</li>
            <li>полнота и образность раскрытия темы</li>
            <li>качество оформления и наглядность материала</li>
            <li>соответствие творческого уровня возрасту автора</li>
            <li>степень самостоятельности выполнения</li>
        </ol>
        <h2 class="font-bold text-2xl mt-5">Требование к файлу:</h2>
        <ol class="text-center">
            <li>Объем файла с работой не должен превышать 1 Мб.</li>
        </ol>

        @auth
        <form method="GET" action="{{ route('request.create') }}">
            @csrf
            <button type="submit" class="bg-blue-500 mt-4 ml-auto text-white font-bold py-2 px-4 rounded">
                принять участие
            </button>
        </form>
    </div>
        @else
        <a class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs mt-2 text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" 
        href="{{ route('register') }}">
            принять участие
        </a>
    </div>
        @endauth
    </div>
@endsection
