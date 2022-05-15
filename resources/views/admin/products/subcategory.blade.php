
<option value="{{$subcategory->id}}">&nbsp;&nbsp;&nbsp;&raquo;&nbsp;{{$subcategory->category_name}}</option>
@if ($subcategory->subcategories())
    @foreach ($subcategory->subcategories()->get() as $subCategory)
        @include('admin.products.subcategory', ['subcategory' => $subCategory])
    @endforeach
@endif
