<div class="flex justify-center items-center bg-gray-100">
    <div class="bg-white shadow-md rounded-lg p-4 max-w-md w-full mb-2">
        <h2 class="font-bold text-xl mb-2">Заявка от {{ $work->created_at ? $work->created_at->format('d.m.Y') : 'Неизвестное время' }}</h2>
        <p><strong>ФИО участника:</strong> {{ $work->user->lastname . ' ' . $work->user->midlename . ' ' . $work->user->name }}</p>
        <p><strong>Класс:</strong> {{ $work->user->class }}</p>
        <p><strong>Школа:</strong> {{ $work->user->school }}</p>
        <p><strong>Название работы:</strong> {{ $work->title }}</p>
        <p><strong>Категория:</strong> {{ $work->category->title }}</p>
        <p><strong>Время:</strong> {{ $work->created_at }}</p>

        @if($work->path_img)
            <div class="mt-4">
                <img src="{{ Storage::url($work->path_img) }}" class="contact-block_img" alt="Изображение открытки">
                <a href="{{ Storage::url($work->path_img) }}" download class="text-blue-500 underline">Скачать изображение</a>
            </div>
        @else
            <span>Нет изображения</span>
        @endif

        <!-- Поле для выставления итогового балла -->
        <div class="mt-4">
            <label for="scoreInput-{{ $work->id }}" class="block font-bold">Итоговый балл:</label>
            <input type="number" id="scoreInput-{{ $work->id }}" value="{{ $work->score }}" class="border rounded p-2 w-full" min="0">
            <button onclick="updateScore('{{ $work->id }}')" class="mt-2 bg-blue-500 text-white rounded p-2">Сохранить балл</button>
        </div>
    </div>
</div>

<script>
function updateScore(workId) {
    const scoreInput = document.getElementById(`scoreInput-${workId}`);
    const scoreValue = scoreInput.value;

    const formData = new FormData();
    formData.append('score', scoreValue);
    
    fetch(`/works/${workId}/score`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Балл успешно обновлён');
        } else {
            alert('Ошибка при обновлении балла');
        }
    })
    .catch(error => {
        console.error('Ошибка:', error);
    });
}
</script>
