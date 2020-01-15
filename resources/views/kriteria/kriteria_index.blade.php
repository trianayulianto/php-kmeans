@extends('theme.main')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kriteria</h1>
        <a href="#" class="btn btn-primary pull-right" id="addKriteria">
            <i class="fas fa-plus"></i> Tambah
        </a>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <div class="text-xs font-weight-bold text-primary text-uppercase">Claster</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-md text-sm">
                            <thead>
                                <tr>
                                    <th width="8%">No</th>
                                    <th>Nama</th>
                                    <th>Keterangan</th>
                                    <th width="180">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="show_kriteria">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal-->
    <div class="modal fade" id="modaldetail" tabindex="-1">
        <div class="modal-dialog" role="dialog">
            <div class="modal-content border-0">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-light" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form class="submit_input" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="form-control-label">Nama Kriteria</label>
                            <input type="text" name="name" id="name" class="form-control col-12">
                        </div>
                        <div class="form-group">
                            <label for="description" class="form-control-label">Keterangan</label>
                            <input type="text" name="description" id="description" class="form-control col-12">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function show() {
            $.ajax({
                type: "get",
                url: "{{ route('getAllKriteria') }}",
                dataType: "json",
                success: function (response) {
                    let element;
                    let lastKey = parseInt(response.length) + 1;
                    $.map(response, function (value, key) {
                        let i = parseInt(key) + 1;
                        element += '<tr>'+
                            '<td>'+i+'</td>'+
                            '<td>'+value.name+'</td>'+
                            '<td>'+value.description+'</td>'+
                            '<td><a href="#" class="font-weight-bold text-warning editKriteria" row-id="'+key+'" data-id="'+value.id+'">Ubah</a> | '+
                            '<a href="#" class="font-weight-bold text-danger destroyKriteria" data-id="'+value.id+'">Hapus</a></td>'+
                        '</tr>';
                    });
                    $('#show_kriteria').html(element);
                }
            });
            $('#modaldetail').modal('hide');
        }

        function ajaxOption(data, id) {
            if (id == 0) {
                $.ajax({
                    type: "post",
                    url: "{{ route('storeKriteria') }}",
                    data: data,
                    dataType: "json",
                    success: function (response) {

                    }
                });
            } else {
                $.ajax({
                    type: "put",
                    url: "{{ route('updateKriteria') }}",
                    data: data,
                    dataType: "json",
                    success: function (response) {

                    }
                });
            }
        }

        $(document).ready(function () {
            show();
        });

        $('#addKriteria').click(function (e) {
            e.preventDefault();
            $('#modaldetail').modal('show');
            $('#modaldetail').find('.modal-title').html('Tambah kriteria');
        });

        $('.submit_input').submit(function (e) {
            e.preventDefault();
            var data = $(this).serialize();
            var id = $('#modaldetail').find('input[name="id"]').val();
            if (id == undefined) {
                id = 0;
            }
            ajaxOption(data, id);
            show();
        });

        $(document).on('click', '.editKriteria', function (e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            $('#modaldetail').modal('show');
            $('#modaldetail').find('.modal-title').html('Ubah kriteria');
            $.ajax({
                type: "get",
                url: "{{ route('editKriteria') }}",
                data: {
                    id: id
                },
                dataType: "json",
                success: function (response) {
                    $('.modal-body').prepend('<input name="id" value="'+id+'" type="hidden">')
                    $('#modaldetail').find('input[name="name"]').val(response.name);
                    $('#modaldetail').find('input[name="description"]').val(response.description);
                }
            });
        });

        $(document).on('click', '.destroyKriteria', function(e) {
            e.preventDefault();
            if (!confirm("Do you want to delete")){
                return false;
            }
            let id = $(this).attr('data-id');
            $.ajax({
                type: "delete",
                url: "{{ route('destroyKriteria') }}",
                data: {
                    id: id
                },
                dataType: "json",
                success: function (response) {

                }
            });
            show();
        });

        $("#modaldetail").on('hide.bs.modal', function(){
            $('#modaldetail').find('input[name="id"]').remove();
        });

    </script>
@endpush
