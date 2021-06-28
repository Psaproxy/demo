<select class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full"
        name="author_id"
        id="author_id">
    @foreach ($authors as $author)
        <option value="{{ $author->id }}"
                @if($author->id === $active) selected @endif>
                {{ $author->name }}
        </option>
    @endforeach
</select>