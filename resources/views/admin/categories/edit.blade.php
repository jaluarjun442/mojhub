@extends('layouts.admin')

@section('content')
<div class="content-wrapper" style="min-height: 1345.31px;">

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row mt-1">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Category</h3>
                        </div>
                        @if ($errors->any())
                        <div class="">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li class="text-danger">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <!-- Form for editing category -->
                        <form id="form" action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT') <!-- Specify the HTTP method as PUT for updating -->
                            <div class="card-body">
                                <div class="row">
                                    <!-- First Column -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Title</label>
                                            <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $category->title) }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="slug">Slug</label>
                                            <input type="text" class="form-control" name="slug" id="slug" value="{{ old('slug', $category->slug) }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="slug">Platform</label>
                                            <input type="text" class="form-control" name="platform" id="platform" value="{{ old('platform', $category->platform) }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" id="status" class="form-control" required>
                                                <option value="active" {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ old('status', $category->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Second Column -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="image">Image</label>
                                            <input type="file" class="form-control" name="image" id="image">
                                        </div>

                                        <div class="form-group">
                                            <label for="parent_category_id">Parent Category</label>
                                            <select name="parent_category_id" id="parent_category_id" class="form-control">
                                                <option value="">None</option>
                                                @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ $category->parent_category_id == $cat->id ? 'selected' : '' }}>{{ $cat->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update Category</button>
                                <a href="{{ route('admin.categories.index')}}"><button type="button" class="btn btn-info">Cancel</button></a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->

                </div>
                <!--/.col (left) -->

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection

@section('custom_js')
<script src="{{ asset('admin_assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/jquery-validation/additional-methods.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        // Initialize the validation
        $.validator.setDefaults({
            submitHandler: function(form) {
                // Submit the form if validation is successful
                form.submit(); // This ensures that the form is submitted after validation
            }
        });

        // jQuery Validation setup
        $('#form').validate({
            rules: {
                title: {
                    required: true
                },
                slug: {
                    required: true
                },
                image: {
                    required: false // Image is optional for editing
                },
            },
            messages: {
                title: {
                    required: "Please enter title"
                },
                slug: {
                    required: "Please enter slug"
                },
                image: "Please select an image (if you want to update)"
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
@endsection