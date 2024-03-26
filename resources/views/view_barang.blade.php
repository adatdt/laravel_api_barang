<html>
    <head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Barang</title>
        <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" ></script> -->
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    </head>
    <body>
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <a class="nav-link active" href="{{ url('/') }}">Transaksi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/barang') }}">Barang</a>
            </li>
        </ul>
        <p></p>        
        <div class="container">
        <div id="msgIndx"></div>
            <div  style="text-align:right">
            <button type="button" class=" btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModal">
                Tambah Data
            </button>
            </div>
            <p></p>
            <div><h3>Data Barang</h3><div>
            <table class="table table-bordered table-striped">
                <thead style="text-align:center">
                    <tr>
                        <th>NO</th>
                        <th>Nama Barang</th>
                        <th>Kode Barang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @php $no=1@endphp

                    @foreach($data as $data_value)
                    <tr>
                        <td>{{$no}}</td>
                        <td>{{ $data_value->nama_barang }}</td>
                        <td >{{ $data_value->kode_barang }}</td>
                        <td align="center"><a class="btn btn-danger btn-sm" onclick="deleteData({{ $data_value->id }})">Hapus</a> <a class="btn btn-warning btn-sm" id="" onclick="formUpdate({{ $data_value->id }})">update</a></td>
                    </tr>
                    @php $no++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="msg"></div>
                    <div>
                        <div class="form-group">
                            <label >Kode Barang</label>
                                <input type="test" class="form-control" id="kode_barang" placeholder="Kode Barang">
                            </select>
                        </div>
                        <div class="form-group">
                            <label >Nama Barang</label>
                            <input type="test" class="form-control" id="nama_barang" placeholder="Nama Barang">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success btn-sm" id="btnSave" >Simpan</button>
                </div>
                </div>
            </div>
        </div>

        <!-- Modal Update-->
        <div class="modal fade" id="modalUpdate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="msg_update"></div>
                    <div>
                        <div class="form-group">
                            <label >Kode Barang</label>
                            <input  type="text" class="form-control" id="kode_barang_update" placeholder="Kode Barang">
                            </select>
                        </div>
                        <div class="form-group">
                            <label >Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barang_update" placeholder="Nama Barang">
                            <input type="hidden" class="form-control" id="id_update" >
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success btn-sm" id="btnUpdate" >Update</button>
                </div>
                </div>
            </div>
        </div>  
        
        <!-- Modal delete-->
        <div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body" style="text-align:center">
                    Apakah anda Yakin ingin menghapus data ini
                    <input type="hidden" id="idDelete">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success btn-sm" id="btnDelete" >Hapus</button>
                </div>
                </div>
            </div>
        </div>                
        <script>
            $(document).ready(function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });                

                $(`#btnSave`).on("click", function(){
                    $.ajax({
                        url: "{{ url('/barang/save_data') }}",
                        data: `kode_barang=${$(`#kode_barang`).val()}&nama_barang=${$(`#nama_barang`).val()}`,
                        type: 'POST',
                        dataType: 'json',
                        success: function (json) {
                            console.log(json)
                            if(json.status_code ==1)
                            {
                                const dataTable = json.data.data
                                $("#msgIndx").html(`<div class="alert alert-success" role="alert">${json.msg} <button id="closeErr" type="button" class="close closeErr" aria-label="Close">
                                <span aria-hidden="true">×</span>
                                </button></div>`);

                                $('#exampleModal').modal('hide');
                                $(`.closeErr`).on("click",function(){
                                    $("#msgIndx").html("");
                                })

                                let html = getDataTable(dataTable);
                                $(`#tableBody`).html(html)
                            }
                            else
                            {
                                $("#msg").html(`<div class="alert alert-danger" role="alert">${json.msg} <button id="closeErr" type="button" class="close closeErr" aria-label="Close">
                                <span aria-hidden="true">×</span>
                                </button></div>`);
                                $(`.closeErr`).on("click",function(){
                                    $("#msg").html("");
                                })
                            }
                        }
                    });                    

                })
                $(`#btnUpdate`).on("click", function(){
                    $.ajax({
                        url: "{{ url('/barang/update_data') }}",
                        data: `kode_barang=${$(`#kode_barang_update`).val()}&nama_barang=${$(`#nama_barang_update`).val()}&id=${$(`#id_update`).val()}`,
                        type: 'POST',
                        dataType: 'json',
                        success: function (json) {
                            if(json.status_code ==1)
                            {
                                const dataTable = json.data.data
                                $("#msgIndx").html(`<div class="alert alert-success" role="alert">${json.msg} <button id="closeErr" type="button" class="close closeErr" aria-label="Close">
                                <span aria-hidden="true">×</span>
                                </button></div>`);

                                $('#modalUpdate').modal('hide');
                                $(`.closeErr`).on("click",function(){
                                    $("#msgIndx").html("");
                                })

                                let html = getDataTable(dataTable);
                                $(`#tableBody`).html(html)
                            }
                            else
                            {
                                $("#msg_update").html(`<div class="alert alert-danger" role="alert">${json.msg} <button id="closeErr" type="button" class="close closeErr" aria-label="Close">
                                <span aria-hidden="true">×</span>
                                </button></div>`);
                                $(`.closeErr`).on("click",function(){
                                    $("#msg_update").html("");
                                })
                            }
                        }
                    });                    
                })    

                $(`#btnDelete`).on("click", function(){
                    let id = $('#idDelete').val();         
                    $.ajax({
                        url: "{{ url('/barang/delete_data') }}",
                        data: `id=${id}`,
                        type: 'POST',
                        dataType: 'json',
                        success: function (json) {
                            $('#modalDelete').modal('hide');
                            if(json.status_code ==1)
                            {
                                const dataTable = json.data.data
                                $("#msgIndx").html(`<div class="alert alert-danger" role="alert">${json.msg} <button id="closeErr" type="button" class="close closeErr" aria-label="Close">
                                <span aria-hidden="true">×</span>
                                </button></div>`);
                                $(`.closeErr`).on("click",function(){
                                    $("#msgIndx").html("");
                                })

                                let html = getDataTable(dataTable);
                                $(`#tableBody`).html(html)
                            }
                            else
                            {
                                $("#msgIndx").html(`<div class="alert alert-danger" role="alert">${json.msg} <button id="closeErr" type="button" class="close closeErr" aria-label="Close">
                                <span aria-hidden="true">×</span>
                                </button></div>`);
                                $(`.closeErr`).on("click",function(){
                                    $("#msgIndx").html("");
                                })
                            }

                        }
                    });  
                })                
                
                $(`.closeErr`).on("click",function(){
                    $("#msgIndx").html("");
                })
            })

            function getDataTable(dataTable)
            {
                let html =``
                let no = 1;
                for(let i=0; i<dataTable.length; i++)
                {
                    html +=`<tr>
                        <td>${no}</td>
                        <td>${dataTable[i].nama_barang}</td>
                        <td >${dataTable[i].kode_barang}</td>
                        <td align="center"><a class="btn btn-danger btn-sm" onclick=deleteData(${dataTable[i].id})>Hapus</a> <a class="btn btn-warning btn-sm" onclick=formUpdate(${dataTable[i].id})>update</a></td>
                    </tr>`
                    no++
                }
                return html;
            }

            function formUpdate(id)
            {
                
                $.ajax({
                        url: "{{ url('/barang/get_data_id') }}",
                        data: `id=${id}`,
                        type: 'POST',
                        dataType: 'json',
                        success: function (json) {
                            $("#nama_barang_update").val(json.data.nama_barang)
                            $("#kode_barang_update").val(json.data.kode_barang)
                            $("#id_update").val(json.data.id)
                            $('#modalUpdate').modal('show');
                        }
                    });                
            }

            function deleteData(id)
            {
                $('#modalDelete').modal('show');
                $('#idDelete').val(id);                
            }
        </script>

    </body>
</html>