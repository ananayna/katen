@extends('layouts.backend_master')
@section('backend_main')
<div class="row">
    <div class="col-lg-12">
      <div class="card-style mb-30">
        <h4 class="mb-10">All Post List
        </h4>
        <div class="table-wrapper table-responsive">
          <table class="table ">
            <thead>
              <tr>
                <th class="lead-info">
                  <h6>F. Image</h6>
                </th>
                <th class="lead-info">
                    <h6>Title</h6>
                  </th>
                <th class="lead-email">
                  <h6>Author</h6>
                </th>
                <th class="lead-phone">
                  <h6>Category</h6>
                </th>
                <th class="lead-company">
                  <h6>Status</h6>
                </th>
                <th class="lead-company">
                    <h6>Featured</h6>
                </th>
                <th class="lead-company">
                    <h6>Created at</h6>
                </th>
                <th>
                  <h6>Action</h6>
                </th>
              </tr>
              <!-- end table row-->
            </thead>
            <tbody>
              @forelse ($posts as $post)
              <tr>
                <td class="min-width">
                      <img class="img-thumbnail" src="{{ asset('storage/post/'.$post->featured_image) }}" alt="" width="70">
                </td>
                <td class="min-width">
                    <p><a href="#0">{{ str($post->title)->substr(0,10) }}</a></p>
                  </td>
                <td class="min-width">
                  <p>{{ $post->user->name }}</p>
                </td>
                <td class="min-width">
                  <p>{{ $post->category->name }}</p>
                </td>
                <td class="min-width">
                    <div class="form-check form-switch toggle-switch">
                        <input class="form-check-input change_status" type="checkbox" id="toggleSwitch2" {{ $post->status  ? "checked":"" }} data-post-id="{{ $post->id }}">
                      </div>
                </td>
                <td class="min-width">

                    <button class="main-btn light-btn btn-hover btn-sm change_featured">
                        <i class="lni lni-star-{{ $post->is_featured ? 'fill' : 'empty' }}" data-featured-id="{{ $post->id }}"></i>
                    </button>
                </td>
                <td class="min-width">
                    <p>{{ Carbon\Carbon::parse($post->created_at)->format('d-M-Y') }}</p>
                </td>
                <td>
                  <div class="action">
                    <button class="text-danger">
                      <i class="lni lni-eye"></i>
                    </button>
                    <button class="text-danger">
                        <i class="lni lni-pencil-alt"></i>
                      </button>
                      <button class="text-danger">
                        <i class="lni lni-trash-can"></i>
                      </button>
                  </div>
                </td>
              </tr>
              @empty
                  <tr>
                    <td>
                        <div class="alert alert-danger"> No Post Found!</div>
                    </td>
                  </tr>
              @endforelse
              <!-- end table row -->
            </tbody>
          </table>
          <!-- end table -->
        </div>
        <div>
            {{ $posts->links() }}
        </div>
      </div>
      <!-- end card -->
    </div>
    <!-- end col -->
  </div>
@endsection

@push('additional.js')
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



        $('.change_status').on('change', function(){
            $.ajax({
                url: "{{ route('post.change_status') }}",
                method:"GET",
                data:{
                    post_id: $(this).data('post-id')
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


{{-- <script>

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



    $('.change_featured').on('change', function(){
        $.ajax({
            url: "{{ route('post.change_featured') }}",
            method:"GET",
            data:{
                featured_id: $(this).data('featured-id')
            },
            success:function(res){
                Toast.fire({
                    icon: "success",
                    title: "Status change successfully"
                });
            }
        })
    })
</script> --}}
@endpush
