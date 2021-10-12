@extends('admin.admin_master')

@section('admin')

    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href=""><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">All Brands</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="row">

                <div class="col-12">

                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Brands</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Brand Name</th>
                                            <th>Image</th>
                                            <th>Created at</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php($i = 1)
                                        @foreach ($brands as $item)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $item->brand_name_en }}</td>
                                                <td><img src="{{ asset($item->brand_image) }}" alt=""></td>
                                                <td>
                                                    @if ($item->created_at == null)
                                                        <span class="text-danger"> No Date Set</span>
                                                    @else
                                                        {{ $item->created_at }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ url('brand/edit/' . $item->id) }}"
                                                        class="btn btn-primary">Edit</a>

                                                    <a href="{{ url('brand/delete/' . $item->id) }}"
                                                        onclick="return confirm('Are you sure you want to delete')"
                                                        class="btn btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
