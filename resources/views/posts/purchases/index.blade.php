<x-app-layout>
    <div class="mt-10">
        <h1 class="text-center text-lg">買い物かご一覧</h1>

        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mt-3">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3 px-6">No</th>
                    <th scope="col" class="py-3 px-6">商品名</th>
                    <th scope="col" class="py-3 px-6">タイトル</th>
                    <th scope="col" class="py-3 px-6">金額</th>
                    {{-- <th scope="col" class="py-3 px-6"></th>
                    <th scope="col" class="py-3 px-6"></th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ( $purchases as $purchase )
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="py-4 px-6">{{ $purchase->id }}</td>
                    {{-- <td class="py-4 px-6">{{ $purchase->post_id->title }}</td>
                    <td class="py-4 px-6">{{ $purchase->post_id->price }}</td> --}}
                    {{-- <td class="py-4 px-6">
                        <a href="{{ route('events.show', $event) }}"
                            class="inline-block bg-blue-500 hover:bg-blue-700 text-center text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20">
                            {{ __('Details') }}
                        </a>
                    </td>
                    <td class="py-4 px-6"><a href="{{ route('events.edit', $event) }}"
                            class="inline-block bg-green-500 hover:bg-green-700 text-center text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20">
                            {{ __('Edit') }}
                        </a>
                    </td>
                    <td class="py-4 px-6">
                        <form action="{{ route('events.destroy', $event) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="{{ __('Delete') }}"
                                onclick="if(!confirm('削除しますか？')){return false};"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20">
                        </form>
                    </td> --}}
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
