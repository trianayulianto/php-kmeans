@extends('theme.main')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Alternatif</h1>
        <a href="#" class="btn btn-sm btn-primary pull-right" id="addAlternatif">
            <i class="fas fa-plus"></i> Tambah
        </a>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <div class="text-xs font-weight-bold text-primary text-uppercase">Data Alternatif</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-md text-sm">
                            <thead id="show_column">
                            </thead>
                            <tbody id="show_data">
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
        function showColumn() {
            let elm;
            $.ajax({
                type: "get",
                url: "{{ route('getAllKriteria') }}",
                dataType: "json",
                success: function (response) {
                    elm += '<tr><th width="30">No</th><th>Nama Alternatif</th>';
                    $.map(response, function (value, key) {
                        elm += '<th>'+value.name+'</th>';
                    });
                    elm += '<th width="160">Aksi</th></tr>';

                    $('#show_column').html(elm);
                }
            }).done(function () {
                showData();
            });
        }

        function showData() {
            let elm;
            $.ajax({
                type: "get",
                url: "{{ route('getAllAlternat') }}",
                dataType: "json",
                success: function (response) {
                    $.map(response, function (value, key) {
                        let i = parseInt(key) + 1;
                        elm += '<tr><td>'+i+'</td><td>'+value.name+'</td>';
                        $.map(value.nilai_kriteria, function (row, k) {
                            elm += '<td>'+row+'</td>';
                        });
                        elm += '<td><a href="#" class="font-weight-bold text-warning editAltrnatif" data-id="'+value.id+'">Ubah</a> | '+
                            '<a href="#" class="font-weight-bold text-danger destroyAltrnatif" data-id="'+value.id+'">Hapus</a></td>'+
                        '</tr>';
                    });

                    $('#show_data').html(elm);
                }
            });
            $('#modaldetail').modal('hide');
        }

        function showForm(id = null) {
            $.ajax({
                type: "get",
                url: "{{ route('getAllKriteria') }}",
                dataType: "json",
                success: function (response) {
                    let elm = '<div class="form-group">'+
                        '<label for="name" class="form-control-label">Nama Alternatif</label>'+
                        '<input type="text" class="form-control col-12" name="name" id="name">'+
                    '</div>';
                    $.map(response, function (value, key) {
                        elm += '<div class="form-group">'+
                            '<label for="data[]" class="form-control-label">Nilai '+value.name+'</label>'+
                            '<input type="text" class="form-control col-12" name="data[]" id="data['+key+']">'+
                        '</div>';
                    });

                    $('.modal-body').html(elm);
                }
            }).done(function () {
                if (id == null) {
                    return false;
                }
                showById(id);
            });
        }

        function showById(id) {
            $.ajax({
                type: "get",
                url: "{{ route('editAlternat') }}",
                data: {
                    id: id
                },
                dataType: "json",
                success: function (response) {
                    $('.modal-body').prepend('<input name="id" value="'+id+'" type="hidden">')
                    $('input[name="name"]').val(response.name);
                    $.map(response.nilai_kriteria, function (value, key) {
                        $('input[id="data['+key+']"]').val(value);
                    });
                }
            });
        }

        function saveData(data, id = null) {
            if (id == null) {
                $.ajax({
                    type: "post",
                    url: "{{ route('storeAlternat') }}",
                    data: data,
                    dataType: "json",
                    success: function (response) {

                    }
                });
                return false;
            }
            $.ajax({
                type: "put",
                url: "{{ route('updateAlternat') }}",
                data: data,
                dataType: "json",
                success: function (response) {

                }
            });
        }

        $(document).ready(function () {
            showColumn();
        });

        $(document).on('click', '#addAlternatif', function (e) {
            e.preventDefault();
            $('#modaldetail').modal('show');
            $('#modaldetail').find('.modal-title').html('Tambah alternatif');
            showForm();
        });

        $(document).on('click', '.editAltrnatif', function (e) {
            e.preventDefault();
            $('#modaldetail').modal('show');
            $('#modaldetail').find('.modal-title').html('Ubah alternatif');
            let id = $(this).attr('data-id');
            showForm(id);
        });

        $('.submit_input').submit(function (e) {
            e.preventDefault();
            var data = $(this).serialize();
            var id = $('#modaldetail').find('input[name="id"]').val();
            if (id == undefined) {
                id = null;
            }
            saveData(data, id);
            showData();
        });

        $(document).on('click', '.destroyAltrnatif', function(e) {
            e.preventDefault();
            if (!confirm("Do you want to delete")){
                return false;
            }
            let id = $(this).attr('data-id');
            $.ajax({
                type: "delete",
                url: "{{ route('destroyAlternat') }}",
                data: {
                    id: id
                },
                dataType: "json",
                success: function (response) {

                }
            });
            showData();
        });

        $("#modaldetail").on('hide.bs.modal', function(){
            $('#modaldetail').find('input[name="id"]').remove();
        });

    </script>
@endpush
