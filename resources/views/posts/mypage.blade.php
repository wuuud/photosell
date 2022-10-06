<x-app-layout>
    <x-flash-message :message="session('notice')" />
    <x-validation-errors :errors="$errors" />
    <div class="flex flex-wrap -mx-1 lg:-mx-4 mb-4">
        <div class="container max-w-7xl mx-auto px-4 md:px-12 pb-3 mt-3">
            <div class="flex flex-wrap -mx-1 lg:-mx-4 mb-4">
                {{-- 売上合計 --}}
                {{-- <div>
                    <h1>売上合計</h1>
                    <table border="1" style="border-collapse: collapse; border-color: rgb(213, 67, 54)">
                        <thead>
                            <tr>
                                <th>500円</th>
                                <th>1000円</th>
                                <th>2000円</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>合計</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($purchases as $purchase)
                            <tr>
                                <td>{{ $purchase->category_id[0] }}</td>
                                    <td>{{ $purchase->category_id[1] }}</td>
                                    <td>{{ $purchase->category_id[2] }}</td>
                                <td><a href="{{ route('posts.show', $post) }}"
                                        class="bg-emerald-500 hover:bg-emerald-300 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2">
                                        詳細</a></td>
                                <td>
                                    <a href="{{ route('posts.edit', $post) }}"
                                        class="bg-emerald-500 hover:bg-emerald-300 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2">
                                        編集</a>
                                </td>

                                <td>
                                    <form action="{{ route('posts.destroy', $post) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" value="削除"
                                            onclick="if(!confirm('削除しますか？')){return false};"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20">
                                    </form>
                                </td>
                                <td>{{ $total }}</td> 
                            </tr>
                        </tbody>
                        
                        @endforeach
                    </table>
                </div> --}}


                {{-- 検索 https://qiita.com/hinako_n/items/7729aa9fec522c517f2a --}}
                <div class="post-search-form md-6">
                    <form class="form-inline" action="{{ route('posts.index') }}" method="GET">
                        @csrf
                        <div class="form-group p-md-2">
                            <input type="search" name="title" class="form-control" placeholder="作品名を入力">
                            <input type="submit" value="検索"
                                class="bg-emerald-900 hover:bg-emerald-900 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2">
                        </div>
                    </form>
                </div>

                {{-- 全件表示 --}}
                <div class="container max-w-7xl mx-auto px-4 md:px-12 pb-3 mt-3">
                    <div class="flex flex-wrap -mx-1 lg:-mx-4 mb-4">
                        @foreach ($posts as $post)
                            <article class="w-full px-4 md:w-1/2 text-xl text-gray-800 leading-normal">
                                <a href="{{ route('posts.show', $post) }}">
                                    <h2
                                        class="font-bold font-sans break-normal text-gray-900 pt-6 pb-1 text-3xl md:text-4xl">
                                        {{ $post->title }}
                                    </h2>

                                    <span class="font-bold text-lime-600">
                                        {{ $post->category->price }}円
                                    </span>
                                    <p class="text-bold text-black-600">
                                        販売数：{{ $post->purchases->count() }}
                                    </p>
                                    <p class="text-bold">撮影者：{{ $post->user->name }}</p>
                                    <p class="text-sm mb-2 md:text-base font-normal text-gray-600">
                                        <span class="text-red-400 font-bold">
                                            {{ date('Y-m-d H:i:s', strtotime('-1 day')) < $post->created_at ? 'NEW' : '' }}</span>
                                        販売開始日:{{ $post->getStartDateAttribute() }}
                                    </p>

                                    <img src="{{ Storage::url($post->image_path) }}" alt="" class="mb-4">
                                    <p class="text-gray-700 text-base">{{ Str::limit($post->body, 30) }}</p>

                            </article>
                        @endforeach
                    </div>
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
