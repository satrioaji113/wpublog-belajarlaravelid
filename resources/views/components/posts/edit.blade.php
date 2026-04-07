@push('style')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
@endpush
<div class=" max-w-4xl relative p-4 bg-white rounded-lg border dark:bg-gray-800 sm:p-5">
    <!-- Modal header -->
    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Post</h3>
    </div>

    {{-- @if ($errors->any())
        <div class="flex p-4 mb-4 text-sm text-fg-danger-strong rounded-base bg-danger-soft border border-danger-subtle"
            role="alert">
            <svg class="w-4 h-4 me-2 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 11h2v5m-2 0h4m-2.592-8.5h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <span class="sr-only">Danger</span>
            <div>
                <span class="font-medium">Ensure that these requirements are met:</span>
                <ul class="mt-2 list-disc list-outside space-y-1 ps-2.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif --}}
    <!-- Modal body -->
    <form action="/dashboard/{{ $post->slug }}" method="POST" id="post-form">
        @csrf
        @method('PATCH')
        <div class="mb-4">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
            <input type="text" name="title" id="title"
                class="@error('title') bg-danger-soft border-danger-strong text-fg-danger-strong focus:ring-danger focus:border-danger placeholder:text-fg-danger-strong @enderror border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                placeholder="Type post title" autofocus value="{{ old('title') ?? $post->title }}">
            @error('title')
                <p class="mt-2.5 text-xs text-fg-danger-strong">{{ $message }}
                </p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
            <select name="category_id" id="category"
                class="@error('category_id') bg-danger-soft border-danger-strong text-fg-danger-strong focus:ring-danger focus:border-danger placeholder:text-fg-danger-strong @enderror border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                <option selected="" value="">
                    Select category</option>
                @foreach (App\Models\Category::get() as $category)
                    <option value="{{ $category->id }}" @selected((old('category_id') ?? $post->category->id) == $category->id)>{{ $category->name }}</option>
                @endforeach

            </select>
            @error('category_id')
                <p class="mt-2.5 text-xs text-fg-danger-strong">{{ $message }}
                </p>
            @enderror
        </div>
        <div class="mb-4"><label for="body"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Body</label>
            <textarea id="body" name="body" rows="4"
                class="hidden @error('body') bg-danger-soft border-danger-strong text-fg-danger-strong focus:ring-danger focus:border-danger placeholder:text-fg-danger-strong @enderror block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300"
                placeholder="Write post body here">{{ old('body') ?? $post->body }}</textarea>
            <!-- Create the editor container -->
            <div id="editor">{!! old('body') ?? $post->body !!}</div>
            @error('body')
                <p class="mt-2.5 text-xs text-fg-danger-strong">{{ $message }}
                </p>
            @enderror
        </div>
        <div class="flex gap-2">
            <button type="submit"
                class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                Update post
            </button>
            <a href="/dashboard"
                class="inline-flex items-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                Cancel
            </a>
        </div>
    </form>
</div>
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

    <!-- Initialize Quill editor -->
    <script>
        const quill = new Quill('#editor', {
            theme: 'snow',
            placeholder: 'Write post body here',
        });


        const postForm = document.querySelector('#post-form');
        const postBody = document.querySelector('#body');
        const quillEditor = document.querySelector('#editor');

        postForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const content = quillEditor.children[0].innerHTML;
            // console.log(content);
            postBody.value = content;

            this.submit();
        })
    </script>
@endpush
