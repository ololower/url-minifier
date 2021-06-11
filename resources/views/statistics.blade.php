@extends('template')

@section('content')
    <header class="flex justify-between px-4 py-2 items-center">
        <h1 class="text-2xl tracking-wide lowercase">{{ $original_href }}</h1>
        @if($visits_count)
        <div class="text-center">
            <div class="text-xs font-bold text-gray-500 uppercase">Переходов</div>
            <div class="text-xl font-black text-blue-400">{{ $visits_count }}</div>
        </div>
        @endif
    </header>

    <div class="bg-gray-100">
        <div class="flex py-8">

            <div class="flex flex-col m-auto">
                @if($is_link_active)
                <div class="text-center mb-6">
                    <input id="link-input"
                           value="{{ $href }}"
                           class="text-center w-64 px-4 py-2 rounded-full text-gray-900 tracking-wide bg-blue-100 border border-blue-400 cursor-pointer">
                    <div id="copy" data-text-copied="Скопировано" class="cursor-pointer text-center font-bold text-gray-600">
                        Копировать
                    </div>
                </div>


                <div class="text-center mb-6">
                    <div class="text-gray-500 text-sm uppercase">Ссылка будет удалена через:</div>
                    <div class="text-gray-600 text-2xl font-bold">{{ $text_link_expired }}</div>
                </div>
                @endif

                @if($visits_count)
                <div class="min-h-screen -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        IP
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Дата перехода
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        UserAgent
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($table_rows as $table_row)
                                <tr class="hover:bg-gray-100">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $table_row['ip'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $table_row['created_at'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {!! $table_row['useragent'] !!}
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @else
                    <p class="pt-6 text-center text-2xl font-black text-gray-300">Здесь будет отображена статистика переходов по минифицированной ссылке</p>
                @endif
            </div>
        </div>
    </div>

    <script>
        function copyToClickboard() {
            let input = document.querySelector("#link-input")
            input.select()
            document.execCommand("copy")

            let copyElement = document.getElementById('copy')
            copyElement.innerText = copyElement.dataset.textCopied
        }

        document.querySelector("#copy").addEventListener("click", copyToClickboard);
    </script>
@endsection
