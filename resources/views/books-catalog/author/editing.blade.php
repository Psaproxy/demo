<x-app-layout>

    <x-slot name="header">
        <div class="flex-grow flex flex-row flex-nowrap justify-items-center">
            <div class="flex-grow flex items-center">

                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $author->name }}
                </h2>

            </div>
        </div>
    </x-slot>

    <div class="mt-4 sm:first:mt-6 lg:first:mt-8 xl:first:mt-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 font-medium leading-tight">
                    <form method="post" action="{{ route('books-authors.update') }}">

                        <input type="hidden" name="_method" value="patch" />
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="mb-5 space-y-2">
                            <x-label for="id" :value="__('general.id')" />

                            <x-input class="block mt-1 w-full"
                                     type="text"
                                     name="id"
                                     id="id"
                                     readonly
                                     :value="$author->id"
                                     required />

                            @error('id')
                                <div class="text-red-600">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-5 space-y-2">
                            <x-label for="name" :value="__('general.name')" />

                            <x-input class="block mt-1 w-full"
                                     type="text"
                                     name="name"
                                     id="name"
                                     :value="$author->name"
                                     required
                                     autofocus />

                            @error('name')
                                <div class="text-red-600">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>

                            <input class="cursor-pointer rounded-xl px-2 md:px-3 py-1 md:py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 active:bg-grey-900 focus:outline-none border-4 border-white focus:border-purple-200 transition-all"
                                   type="submit"
                                   value="{{ __('general.save') }}">

                            <a class="cursor-pointer rounded-xl px-2 md:px-3 py-1 md:py-2 text-sm font-medium text-gray-500 bg-white hover:text-gray-900 active:text-gray-900 focus:outline-none border-4 border-white focus:border-purple-200 transition-all"
                               href="{{ route('books-authors.list') }}">
                                {{ __('general.cancel') }}
                            </a>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
