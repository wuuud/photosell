<x-app-layout>
    <div class="container max-w-7xl mx-auto px-4 md:px-12 pb-3 mt-3">
        <x-flash-message :message="session('notice')" />
        <div class="flex flex-wrap -mx-1 lg:-mx-4 mb-4">
            <div class="container max-w-7xl mx-auto px-4 md:px-12 pb-3 mt-3">
                <div class="flex flex-wrap -mx-1 lg:-mx-4 mb-4">
                {{-- <p class="font-green">売上合計：{{ $total }}</p> --}}
                    @foreach ($posts as $post)
                        <article class="w-full px-4 md:w-1/2 text-xl text-gray-800 leading-normal">
                            <a href="{{ route('posts.show', $post) }}">
                                <h2
                                    class="font-bold font-sans break-normal text-gray-900 pt-6 pb-1 text-3xl md:text-4xl">
                                    {{ $post->title }}
                                </h2>
                                <span class="text-lime-600">
                                販売数：{{ $post->purchases->count() }}
                                </span>
                                <p>撮影者：{{ $post->user->name }}</p>
                                <p class="text-sm mb-2 md:text-base font-normal text-gray-600">
                                    <span class="text-red-400 font-bold">
                                        {{ date('Y-m-d H:i:s', strtotime('-1 day')) < $post->created_at ? 'NEW' : '' }}</span>
                                    販売開始日:{{ $post->getStartDateAttribute() }}
                                </p>
                                
                                <img src="{{ Storage::url($post->image_path) }}" alt="" class="mb-4">
                                <p class="text-gray-700 text-base">{{ Str::limit($post->body, 30) }}</p>
                            </a>
                            
                        </article>
                    @endforeach
                </div>
                {{ $posts->links() }}
            </div>
</x-app-layout>
