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
                            <h3 class="card-title">Create Website</h3>
                        </div>

                        <form id="form" action="{{ route('admin.website.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <!-- First Column -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Title</label>
                                            <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="slug">Slug</label>
                                            <input type="text" class="form-control" name="slug" id="slug" value="{{ old('slug') }}" required>
                                        </div>
                                    </div>

                                    <!-- Second Column -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="image">Logo</label>
                                            <input type="file" class="form-control" name="image" id="image">
                                        </div>
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" id="status" class="form-control" required>
                                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="image">Header Style</label>
                                            <textarea class="form-control" id="header_style" name="header_style"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="image">Header Script</label>
                                            <textarea class="form-control" id="header_script" name="header_script"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="image">Foter Script</label>
                                            <textarea class="form-control" id="footer_script" name="footer_script"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Create Website</button>
                                <a href="{{ route('admin.website.index')}}"><button type="button" class="btn btn-info">Cancel</button></a>
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
                }
            },
            messages: {
                title: {
                    required: "Please enter title"
                },
                slug: {
                    required: "Please enter slug"
                }
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