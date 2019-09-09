@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                   <div class="container">
                        <h1>Perpustakaan</h1>
                        <a class="btn btn-success" href="javascript:void(0)" id="buatPetugas">Petugas</a>
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode petugas</th>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Jabatan</th>
                                    <th>Telp</th>
                                    <th>Alamat</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
   
                    <div class="modal fade" id="ajaxModel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="modelHeading"></h4>
                                </div>
                                <div class="modal-body">
                                    <form id="petugasForm" name="petugasForm" class="form-horizontal">
                                       <input type="hidden" name="petugas_id" id="petugas_id">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-4 control-label">Kode petugas</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="kode_petugas" name="kode_petugas" placeholder="" value="" maxlength="50" required="">
                                            </div>
                                        </div>
                         
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Nama</label>
                                            <div class="col-sm-12">
                                                <input type="text" id="nama" name="nama" required="" placeholder="" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Jenis Kelamin</label>
                                            <div class="col-sm-12">
                                                <input type="text" id="jk" name="jk" required="" placeholder="" class="form-control">
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-sm-3 control-label">Jabatan</label>
                                            <div class="col-sm-12">
                                                <input type="text" id="jabatan" name="jabatan" required="" placeholder="" class="form-control">
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-sm-3 control-label">Telp</label>
                                            <div class="col-sm-12">
                                                <input type="text" id="telp" name="telp" required="" placeholder="" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Alamat</label>
                                            <div class="col-sm-12">
                                                <textarea class="form-control" id="alamat" name="alamat" placeholder="Enter Alamat" value="" maxlength="10" required="">
                                                </textarea>
                                            </div>
                                        </div>
                          
                                        <div class="col-sm-offset-2 col-sm-20">
                                         <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                                         </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
  $(function () {
     
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('petugas.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'kode_petugas', name: 'kode_petugas'},
            {data: 'nama', name: 'nama'},
            {data: 'jk', name: 'jk'},
            {data: 'jabatan', name: 'jabatan'},
            {data: 'telp', name: 'telp'},
            {data: 'alamat', name: 'alamat'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
     
    $('#buatPetugas').click(function () {
        $('#saveBtn').val("create-product");
        $('#petugas_id').val('');
        $('#petugasForm').trigger("reset");
        $('#modelHeading').html("Create New Petugas");
        $('#ajaxModel').modal('show');
    });
    
    $('body').on('click', '.editPetugas', function () {
      var petugas_id = $(this).data('id');
      $.get("{{ route('petugas.index') }}" +'/' + petugas_id +'/edit', function (data) {
          $('#modelHeading').html("Edit petugas");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#petugas_id').val(data.id);
          $('#kode_petugas').val(data.kode_petugas);
          $('#nama').val(data.nama);
          $('#jk').val(data.jk);
          $('#telp').val(data.telp);
          $('#jabatan').val(data.jabatan);
          $('#alamat').val(data.alamat);
      })
   });
    
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
          data: $('#petugasForm').serialize(),
          url: "{{ route('petugas.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#petugasForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });
    });
    
    $('body').on('click', '.deletePetugas', function () {
     
        var petugas_id = $(this).data("id");
        confirm("Are You sure want to delete !");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('petugas.store') }}"+'/'+petugas_id,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
     
  });
</script>

@endsection
