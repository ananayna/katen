@extends('layouts.backend_master')

@section('backend_main')

<div class="row">
    <div class="col-12">
        <div class="card-style mb-30">
            <h6 class="mb-25">Add New Post</h6>
                <form action="{{ route('post.store') }}" class="row" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-lg-12">
                        <div class="input-style-1">
                            <label>Title</label>
                            <input type="text" placeholder="title" name="title" value="{{ old('title') }}">
                            @error('title')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                          </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="select-style-1">
                            <label>Category</label>
                            <div class="select-position">
                              <select name="category" id="category" value="{{ old('category') }}">
                                <option selected disabled>Select category</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach

                              </select>
                              @error('category')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                            </div>
                          </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="select-style-1">
                            <label>Sub Category</label>
                            <div class="select-position">
                              <select name="subcategory" id="subcategory" value="{{ old('subcategory') }}">
                                <option>No sub Category found!</option>
                              </select>
                              @error('subcategory')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                            </div>
                          </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="input-style-1">
                            <label>Featured Image</label>
                            <input type="file" placeholder="title" name="featured_image" value="{{ old('featured_image') }}">
                            @error('featured_image')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                          </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="input-style-1">
                            <label>Short Description</label>
                            <textarea placeholder="Short description" name="short_description" value="{{ old('short_description') }}"></textarea>
                            @error('short_description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                          </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="input-style-1">
                            <label> Description</label>
                            <textarea id="post_description_editor" name="description" value="{{ old('description') }}"></textarea>
                            @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                          </div>
                    </div>
                    <div class="col-lg-12">
                        <button class=" w-100 main-btn primary-btn btn-hover" type="submit">Add Post</button>
                    </div>
                </form>
          </div>
    </div>
</div>

@endsection
@push('additional.js')
<script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#post_description_editor' ) )
        .catch( error => {
            console.error( error );
        } );

        $('#category').on('change', function(){
            $.ajax({
                url: `{{route('subcategory.getSubcategory')}}`,
                method :`GET`,
                data: {
                    category: $(this).val()
                },
                success: function(res){

                    if (res.length > 0){
                        let options=[`<option value="" selected disabled> Selected sub category </option> `]
                        res.forEach(function(subcategory){
                            let option = `<option value="${subcategory.id}">${subcategory.name}</option>`;

                            options.push(option);
                        });
                        $('#subcategory').html(options)
                    }else{
                        $('#subcategory').html(`<option selected disabled> No Subcategory found!</option>`)
                    }

                }
            });
        });
</script>


@endpush
