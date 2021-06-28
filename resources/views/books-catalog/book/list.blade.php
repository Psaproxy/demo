<x-app-layout>

    <x-slot name="header">
        <div class="flex-grow flex flex-row flex-nowrap justify-items-center">
            <div class="flex-grow flex items-center">

                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('books.title') }}
                </h2>

            </div>
            <div class="flex-grow-0 flex items-center">

                <a class="rounded-xl px-2 md:px-3 py-1 md:py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 active:bg-grey-900 focus:outline-none border-4 border-white focus:border-purple-200 transition-all"
                   href="{{ route('books.adding') }}">
                    {{ __('general.add') }}
                </a>

            </div>
        </div>
    </x-slot>

    <section>
        @each('books-catalog/book/list-item', $books, 'book')
    </section>

</x-app-layout>
