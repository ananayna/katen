@extends('layouts.backend_master')
@section('page_title')
 Subcategories
@endsection
@section('backend_main')

<div class="row">

    <div class="col-lg-8">
        <div class="card-style mb-30">
            <h6 class="mb-10">All Categories</h6>
            <div class="table-wrapper table-responsive">
              <table class="table striped-table">
                <thead>
                <tr>
                    <th><h6>SL No.</h6></th>
                    <th>
                      <h6>Name</h6>
                    </th>
                    <th>
                      <h6>Slug</h6>
                    </th>
                    <th>
                        <h6>Parent Category</h6>
                    </th>
                    <th>
                      <h6>status</h6>
                    </th>
                    <th>
                        <h6>Action</h6>
                    </th>
                </tr>
                  <!-- end table row-->
                </thead>
                <tbody>
                    @forelse ($subcategories as $key=> $subcategory)
                    <tr>
                        <td>
                          <h6 class="text-sm"> {{ $subcategories->firstitem()+$key }}. </h6>
                        </td>
                        <td>
                          <p>{{ $subcategory->name }}</p>
                        </td>

                        <td>
                          <p>{{ $subcategory->slug }}</p>
                        </td>
                        <td>
                            <p>{{ $subcategory->category->name }}</p>
                          </td>
                        <td>
                            <div class="form-check form-switch toggle-switch">
                                <input class="form-check-input change_status" type="checkbox" id="toggleSwitch2" {{ $subcategory->status  ? "checked":"" }} data-subcategory-id="{{ $subcategory->id }}">
                              </div>
                        </td>
                        <td>
                            <a href="{{ route('subcategory.edit',$subcategory->id ) }}" class="btn-sm main-btn info-btn btn-hober">
                                <i class="lni lni-pencil-alt"></i>
                            </a>

                            <button class="btn-sm main-btn danger-btn btn-hober delete_btn">
                                <i class="lni lni-trash-can"></i>
                            </button>
                            <form action="{{ route('subcategory.delete',$subcategory->id ) }}" method="POST">
                                @csrf
                                @method('DELETE')

                            </form>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-danger">
                                <strong>No data found!</strong>
                            </td>
                        </tr>
                    @endforelse

                  <!-- end table row -->
                  <!-- end table row -->
                </tbody>
              </table>
              <!-- end table -->
            </div>
            <div>
                {{ $subcategories->links() }}
            </div>
          </div>
    </div>

    <div class="col-lg-4">
        <div class="card-style mb-30">
            <h6 class="mb-25">{{ isset($editData) ? 'Update' :'Add new' }} Sub category</h6>
            <form action="{{ isset($editData) ? route('subcategory.update', $editData->id) : route('subcategory.store') }}" method="POST">
                @isset($editData)
                    @method('PUT')
                @endisset
                @csrf
                <div class="select-style-1">
                    <label>Subcategory</label>
                    <div class="select-position">
                      <select name="category">
                        <option>Select Subcategory</option>
                        @forelse ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @empty
                        <option>No category found!</option>
                        @endforelse
                      </select>
                      @error('category')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    </div>
                  </div>
                <div class="input-style-1">
                    <label>Sub Category Name</label>
                    <input type="text" placeholder="Sub Category Name" name="name" value="{{ isset($editData) ? $editData->name :'' }}">
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                  <!-- end input -->
                  <button type="submit" class="main-btn primary-btn btn-hover w-100 btn-sm">{{ isset($editData) ? 'Update' :'Add new' }} Sub category</button>
                </div>
            </form>
    </div>
</div>
@push('additional.js')
{{-- <script src="{{ asset('beckend/assets/js/sweetalert2@11.js') }}"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

    const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
            });


        $('.delete_btn').on('click',function(){

            Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
        }).then((result) => {
        if (result.isConfirmed) {
           $(this).next('form').submit();
        }
        });

        })

        $('.change_status').on('change', function(){
            $.ajax({
                url: "{{ route('subcategory.change_status') }}",
                method: "GET",
                data:{
                    subcategory_id: $(this).data('subcategory-id')
                },
                success:function(res){
                    Toast.fire({
                        icon: "success",
                        title: "Status change successfully"
                    });
                }
            })
        })
    </script>
@endpush
@endsection
