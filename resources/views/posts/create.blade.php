<x-app-layout>
    <div class="container lg:w-1/2 md:w-4/5 w-11/12 mx-auto mt-8 px-8 bg-white shadow-md">
        <h2 class="text-center text-lg font-bold pt-6 tracking-widest">あなたの作品を販売する</h2>
        
        <x-validation-errors :errors="$errors" />
        

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data"
            class="rounded pt-3 pb-8 mb-4">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="title">
                    タイトル
                </label>
                <input type="text" name="title"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full py-2 px-3"
                    required placeholder="タイトル" value="{{ old('title') }}">
            </div>
            <div class="mb-4">
            <label class="block text-gray-700 text-sm mb-2" for="category">
                金額設定
            </label>
                @foreach ($categories as $category)
                    <p>
                        <label>
                            <input type="radio" name="category_id" id="category"
                            value="{{ $category->id }}"
                            {{-- indexから戻ってきたときに必要 --}} 
                            {{ old('category_id') == $category->id ? 'checked' : '' }}>
                            {{ $category->price }}円
                        </label>
                    </p>
                @endforeach
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="body">
                    概要
                </label>
                <textarea name="body" rows="2"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full py-2 px-3"
                    placeholder="撮影場所などを記載してください。"
                    required>{{ old('body') }}</textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="image">
                    写真
                </label>
                <input type="file" name="image" class="border-gray-300">
            </div>
            <input type="submit" value="販売開始"
                class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        </form>
    </div>
</x-app-layout>
