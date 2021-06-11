@extends('template')

@section('content')
    <div class="bg-gray-100">
        <div class="flex h-screen">
            <div class="m-auto bg-white shadow-lg border rounded w-96 p-8">

                <form action="{{ route('create-link') }}" method="post" class="flex flex-col">
                    @csrf
                    <div class="mb-6">
                        <input
                            type="text"
                            name="link"
                            value="{{ old('link') }}"
                            class="w-full border bg-gray-200 p-2 text-center"
                            placeholder="Вставьте ссылку">
                        @error('link')
                        <div class="text-red-400 font-bold mt-2 text-xs">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <div class="flex justify-between text-xs uppercase">
                            @foreach($allowed_expires as $seconds => $name)
                            <label for="{{ $seconds }}m" class="text-center cursor-pointer">
                                <input id="{{ $seconds }}m"
                                       type="radio"
                                       value="{{ $seconds }}"
                                       name="expired_in_seconds">
                                <div class="block">{{ $name }}</div>
                            </label>
                            @endforeach
                        </div>
                        @error('expired_in_seconds')
                        <div class="text-red-400 font-bold mt-2 text-xs">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="text-center mb-6">
                        <button class="bg-blue-400 p-2 text-center w-48 text-xs text-white font-black uppercase tracking-wide">Минифицировать</button>
                    </div>
                    <small class="text-xs text-gray-300">Для перехода к статистике - введите адрес полученной ссылки в форму выше</small>
                </form>

            </div>
        </div>
    </div>
@endsection
