@extends("layouts.adminlte")

@section("sidebar:categories", "active")

@section("title", "Daftar Kategori")
@section("content")
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Simple Tables</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Simple Tables</li>
                    </ol>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content Header-->
    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#insert-category-modal">
                                    Create new category (modal)
                                </button>
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Category</th>
                                        <th>Show Food List</th>
                                        <th>Show Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $c)
                                        <tr>
                                            <td> {{ $c->id }} </td>
                                            <td> {{ $c->name }} </td>
                                            {{-- Show Food List --}}
                                            <td><button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#food-list-modal" onclick="showFoodList('{{ $c->id }}')">
                                                    Show
                                                </button></td>

                                            {{-- Show Image --}}
                                            <td><button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#image-modal-{{ $c->id }}">
                                                    Show
                                                </button>
                                                @push("modals")
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="image-modal-{{ $c->id }}" tabindex="-1">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Image for {{$c->name}}</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <img class="img-responsive" style="max-width: 250px;"
                                                                        src="/storage/categories/{{ $c->image }}" alt="">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endpush
                                            </td>
                                            <td>
                                                <a class="btn btn-primary"
                                                    href="{{ route("categories.edit", $c->id) }}">Edit</a>
                                                <button class="btn btn-warning" data-bs-target="#update-category-modal-a"
                                                    data-bs-toggle="modal" onclick="getEditForm('{{ $c->id }}')">Edit (modal A)
                                                </button>
                                                <form action="{{ route("categories.destroy", $c->id) }}" method="post">
                                                    @method("DELETE")
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return if(confirm('Are you sure you want to delete category {{ $c->id }} - {{ $c->name }}?') {deleteDataRemove('{{ $c->id }}')}">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-end">
                                <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->

    @stack("modals")
    <div class="modal fade" id="food-list-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title-food-category">Food list for Category -</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modal-body-food-list">
                    Food List
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showFoodList(idcat) {
            $.ajax({
                type: "GET",
                url: "/categories/showListFoods?idcat=" + idcat,
                data: {
                    idcat: idcat,
                    _token: '<?php echo csrf_token() ?>'
                }
                                                        success: function (data) {
                    console.log(data);
                    $("#modal-title-food-category").html("Food list for Category " + data.category);
                    let list = "<ul>";
                    for (let i = 0; i < data.foods.length; i++) {
                        list += "<li>" + data.foods[i].name + "</li>";
                    }
                    list += "</ul>";
                    $("#modal-body-food-list").html(list);
                }
            })
        }
    </script>
@endsection

@push('modals')
    <div class="modal fade" id="insert-category-modal" tabindex="-1">
        {{-- <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div> --}}
    </div>

    <script>
        function getEditForm(idcat) {
            $.ajax({
                type: "POST",
                url: "/categories/getEditForm",
                data: {
                    id: idcat,
                    _token: '<?php echo csrf_token() ?>'
                },
                success: function (data) {
                    $("#modal-content").html(data);
                }
            })
        }

        function saveDataUpdate(idcat) {
            $.ajax({
                type: "POST",
                url: "/categories/saveDataUpdate",
                data: {
                    id: idcat,
                    name: name,
                    _token: '<?php echo csrf_token() ?>'
                },
                success: function (data) {
                    if(data.status == "oke") {
                        $("#td_name_" + idcat).html(name);
                    }
                }
            })
        }

        function deleteDataRemove(idcat) {
            $.ajax({
                type: "POST",
                url: "{{ route('categories.destroy') }}",
                data: {
                    id: idcat,
                    _token: '<?php echo csrf_token() ?>'
                },
                success: function (data) {
                    if(data.status == "oke") {
                        $("#tr_" + idcat).remove();
                    }
                }
            })
        }
    </script>
@endpush