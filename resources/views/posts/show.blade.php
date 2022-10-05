<x-app-layout>
    <div class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-8 px-8 py-4 bg-white shadow-md">
        <x-flash-message :message="session('notice')" />
        <x-validation-errors :errors="$errors" />
        <article class="mb-2">
            <h2 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-1 text-3xl md:text-4xl">
                {{ $post->title }}</h2>
            <h3>撮影者：{{ $post->user->name }}</h3>
            <p class="text-sm mb-2 md:text-base font-normal text-gray-600">
                <span class="text-red-400 font-bold">
                    {{ date('Y-m-d H:i:s', strtotime('-1 day')) < $post->created_at ? 'NEW' : '' }}</span>
                販売開始日:{{ $post->getStartDateAttribute() }}
            </p>
            <br>
            <div class="text-xl font-bold">{{ $post->category->price }}円</div>

            <!-- 購入は他人アカウントのみ https://reffect.co.jp/laravel/laravel-gate-policy-understand-->
            @guest
                <p class="font-bold text-lime-600">購入枚数：{{ $post->purchases->count() }}</p>
            @else
                @if (Auth::user()->id !== $post->user_id)
                    <p class="font-bold text-lime-600">購入枚数：{{ $post->purchases->count() }}</p>
                    <form action="{{ route('posts.purchases.store', $post->id) }}" method="post">
                        @csrf
                        <button class="bg-lime-600 hover:bg-lime-500 text-white font-bold py-2 px-4 rounded"
                            onclick="if(!confirm('カートに入れますか？')){return false};">
                            カートに入れる
                        </button>
                    </form>
                    <br>
                @else
                    <p class="font-bold text-lime-600">購入枚数：{{ $post->purchases->count() }}</p>
                    </form>
                @endif
            @endguest
            <br>
            {{-- <img src="{{ Storage::url('images/posts/' . $post->image) }}" alt="" class="mb-4"> --}}
            <img src="{{ Storage::url($post->image_path) }}" alt="" class="mb-4">
            <p class="text-gray-700 text-base">概要：{!! nl2br(e($post->body)) !!}</p>
        </article>

        {{-- 自分アカウント 更新・削除 --}}
        <div class="flex flex-row text-center my-4">
            @can('update', $post)
                <a href="{{ route('posts.edit', $post) }}"
                    class="bg-emerald-500 hover:bg-emerald-300 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2">編集</a>
            @endcan
            @can('delete', $post)
                <form action="{{ route('posts.destroy', $post) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="削除" onclick="if(!confirm('削除しますか？')){return false};"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20">
                </form>
            @endcan
        </div>

        {{-- コメント --}}
        @auth
            <hr class="my-4">

            <div class="flex justify-end">
                <a href="{{ route('posts.comments.create', $post) }}"
                    class="bg-indigo-500 hover:bg-indigo-300 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline block">コメント登録</a>
            </div>

            <section class="font-sans break-normal text-gray-900 ">
                @foreach ($comments as $comment)
                    <div class="my-2">
                        <span class="font-bold mr-3">{{ $comment->user->name }}</span>
                        <span class="text-sm">{{ $comment->created_at }}</span>
                        <p>{!! nl2br(e($comment->detail)) !!}</p>
                        <div class="flex justify-end text-center">
                            @can('update', $comment)
                                <a href="{{ route('posts.comments.edit', [$post, $comment]) }}"
                                    class="text-sm bg-indigo-500 hover:bg-indigo-300 text-white font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline w-20 mr-2">編集</a>
                            @endcan
                            @can('delete', $comment)
                                <form action="{{ route('posts.comments.destroy', [$post, $comment]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="削除" onclick="if(!confirm('削除しますか？')){return false};"
                                        class="text-sm bg-red-500 hover:bg-red-300 text-white font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline w-20">
                                </form>
                            @endcan
                        </div>
                    </div>
                    <hr>
                @endforeach
            </section>
        @endauth
    </div>
</x-app-layout>
