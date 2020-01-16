@extends('theme.main')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">K-means Cluster</h1>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <div class="text-xs font-weight-bold text-primary text-uppercase">Perhitungan</div>
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group row">
                            <label for="jml_klaster" class="col-form-label col-md-3 text-right">Jumlah Klaster</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="jml_klaster" value="3">
                            </div>
                            <button type="submit" id="submit" class="btn btn-primary btn-md">Proses</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <div class="text-xs font-weight-bold text-primary text-uppercase">Centroids</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table teble-md text-xs">
                            <tbody id="show_centroids">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <div class="text-xs font-weight-bold text-primary text-uppercase">Claster</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table teble-md text-xs">
                            <thead id="show_column"></thead>
                            <tbody id="show_clusters">
                            </tbody>
                        </table>
                    </div>
                </div>
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
                    elm += '<th width="160">Cluster</th></tr>';

                    $('#show_column').html(elm);
                }
            });
        }

        $('#submit').click(function (e) {
            e.preventDefault();
            var k = $('input[name="jml_klaster"]').val();
            $.ajax({
                type: "get",
                url: "{{ route('perhitungan') }}",
                data: {
                    k: k
                },
                dataType: "json",
                success: function (response) {
                    let html;
                    let element;

                    $.map(response.centroids, function (value, i) {
                        var k = parseInt(i)+1;
                        html += '<tr><td> Centroid Ke-'+k+'</td>';
                        for (let j = 0; j < value.length; j++) {
                            html += '<td>'+value[j]+'</td>';
                        }
                        html += '</tr>';
                    });
                    $('#show_centroids').html(html);

                    showColumn();
                    let count = 0;
                    $.map(response, function (data, k) {
                        if (k != 'centroids') {
                            let r = parseInt(k)+1;
                            for (let j = 0; j < data.length; j++) {
                                count++;
                                element += '<tr><td width="10">'+count+'</td>';
                                element += '<td>'+data[j]['attr']+'</td>';
                                for (let i = 0; i < data[j].length - 1; i++) {
                                    element += '<td>'+data[j][i]+'</td>';
                                }
                                element += '<td>'+r+'</td></tr>';
                            }
                        }
                    });
                    $('#show_clusters').html(element);
                }
            });
        });
    </script>
@endpush
