<x-app-layout>
    <div class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-8 px-8 py-4 bg-white shadow-md">
        <x-flash-message :message="session('notice')" />
        <article class="mb-2">
            <h2 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-1 text-3xl md:text-4xl">
                {{ $post->title }}</h2>
            <p class="text-gray-700 text-base">概要：{!! nl2br(e($post->body)) !!}</p>
            <br>
            <p class="font-blue">販売価格</p>
            <p class="font-blue">購入数：{{ $post->purchases->count() }}</p>
            <br>
            <h3>撮影者：{{ $post->user->name }}</h3>
            <p class="text-sm mb-2 md:text-base font-normal text-gray-600">
                <span class="text-red-400 font-bold">
                    {{ date('Y-m-d H:i:s', strtotime('-1 day')) < $post->created_at ? 'NEW' : '' }}</span>
                販売開始日:{{ $post->getStartDateAttribute() }}
            </p>
            {{-- <img src="{{ Storage::url('images/posts/' . $post->image) }}" alt="" class="mb-4"> --}}
            <img src="{{ Storage::url($post->image_path) }}" alt="" class="mb-4">
        </article>

        <!-- 購入は他人アカウントのみ　Review.phpに作ったisLikedByメソッドをここで使用 
        https://qiita.com/kakudaisuke/items/01816910b7b9ecba0486-->
        @guest
            <p class="font-black">購入枚数：{{ $post->purchases->count() }}</p>
        @else
        @if (auth()->user()->id)
            <p class="font-black">購入枚数：{{ $post->purchases->count() }}</p>
            @else
                <form action="{{ route('posts.purchases.store', $post->id) }}" method="post">
                    @csrf
                    <button class="bg-blue-500 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded"
                    onclick="if(!confirm('購入しますか？')){return false};">
                    購入する
                    </button>
                </form>
        @endcan
        @endguest
        
        
        {{--自分アカウント 更新・削除 --}}
        <div class="flex flex-row text-center my-4">
            @can('update', $post) 
            <a href="{{ route('posts.edit', $post) }}" 
                class="bg-purple-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2">編集</a>
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
    </div>
</x-app-layout>
