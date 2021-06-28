<div class="mt-4 sm:first:mt-6 lg:first:mt-8 xl:first:mt-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200 font-medium leading-tight">
                <div class="flex-grow flex flex-row flex-nowrap justify-items-center">

                    <div class="flex-grow">

                        <div class="mb-1">
                            <a href="{{ route('books-authors.editing', ['id'=>$author->id]) }}"
                               class="text-xl text-blue-600 hover:text-blue-800 focus:text-blue-800">
                                {{ $author->name }}
                            </a>
                        </div>

                        <p class="text-xs text-gray-500">
                            <span class="select-none pointer-events-none">{{ __('general.id') }}: </span> {{ $author->id }}
                        </p>

                    </div>
                    <div class="flex-grow-0 flex items-center">

                        <form method="post" action="{{ route('books-authors.delete') }}">
                            <input type="hidden" name="_method" value="delete" />
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $author->id }}">
                            <input class="cursor-pointer rounded-xl px-2 md:px-3 py-1 md:px-1 text-xs md:text-sm font-medium text-white bg-red-500 hover:bg-red-600 active:bg-grey-900 focus:outline-none border-4 border-white focus:border-purple-200 transition-all"
                                   type="submit"
                                   value="{{ __('general.delete') }}">
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>