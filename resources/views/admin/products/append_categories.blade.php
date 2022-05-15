<div class="form-group">
    <label>Select Category Level</label>
    <select class="form-control select2" name="category_id" style="width: 100%;">
        @if (!empty($getcategories))
            {{-- <option value="0">Main Category</option> --}}

            @foreach ($getcategories as $category)

                <option value="{{ $category->id }}">{{ $category->category_name }}</option>

                @if (!empty($category->subcategories()))
                    @foreach ($category->subcategories()->get() as $subcategory)

                        @include('admin.products.subcategory', ['subcategory'=>$subcategory])
                    @endforeach
                @endif
            @endforeach

        @endif

    </select>
</div>
