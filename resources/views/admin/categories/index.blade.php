@extends('layouts.admin')

@section('header_css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('admin_assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin_assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Categories</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item btn btn-success text-white">
                            <a class="text-white" href="{{ route('admin.categories.create') }}">Add Category</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <label for="filterParentCategory">Filter by Parent Category:</label>
                            <select id="filterParentCategory" class="form-control" style="width: 300px;">
                                <option value="">All</option>
                                @foreach($parentCategories as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="card-body">
                            <table id="categoriesTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Image</th>
                                        <th>Parent Category</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('footer_js')
<script src="{{ asset('admin_assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
@endsection

@section('custom_js')
<script>
    $(document).ready(function() {
        const table = $('#categoriesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.categories.index') }}",
                data: function(d) {
                    d.parent_category_id = $('#filterParentCategory').val();
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'slug',
                    name: 'slug'
                },
                {
                    data: 'image',
                    name: 'image',
                    render: function(data) {
                        return data ?
                            `<img src="${data}" alt="Category Image" width="80">` :
                            'No Image';
                    }
                },
                {
                    data: 'parent_category',
                    name: 'parent_category'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $('#filterParentCategory').change(function() {
            table.ajax.reload();
        });
    });
</script>
@endsection