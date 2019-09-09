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
                        <a class="btn btn-success" href="javascript:void(0)" id="buatAnggota">Anggota</a>
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Anggota</th>
                                    <th>Nama</th>
                                    <th>Jenis Kelammin</th>
                                    <th>Jurusan</th>
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
                                    <form id="anggotaForm" name="anggotaForm" class="form-horizontal">
                                       <input type="hidden" name="anggota_id" id="anggota_id">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-4 control-label">Kode anggota</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="kode_anggota" name="kode_anggota" placeholder="" value="" maxlength="50" required="">
                                            </div>
                                        </div>
                         
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Nama</label>
                                            <div class="col-sm-12">
                                                <input type="text" id="nama" name="nama" required="" placeholder="" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Jenis Kelamin</label>
                                            <div class="col-sm-12">
                                                <input type="text" id="jk" name="jk" required="" placeholder="" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Jurusan</label>
                                            <div class="col-sm-12">
                                                <input type="text" id="jurusan" name="jurusan" required="" placeholder="" class="form-control">
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-sm-3 control-label">Alamat</label>
                                            <div class="col-sm-12">
                                                <textarea class="form-control" id="alamat" name="alamat" placeholder="Enter Alamat" value="" maxlength="10" required="">
                                                </textarea>
                                            </div>
                                        </div>
                          
                                        <div class="col-sm-offset-2 col-sm-30">
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
        ajax: "{{ route('anggota.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'kode_anggota', name: 'kode_anggota'},
            {data: 'nama', name: 'nama'},
            {data: 'jk', name: 'jk'},
            {data: 'jurusan', name: 'jurusan'},
            {data: 'alamat', name: 'alamat'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
     
    $('#buatAnggota').click(function () {
        $('#saveBtn').val("create-product");
        $('#anggota_id').val('');
        $('#anggotaForm').trigger("reset");
        $('#modelHeading').html("Create New Anggota");
        $('#ajaxModel').modal('show');
    });
    
    $('body').on('click', '.editAnggota', function () {
      var anggota_id = $(this).data('id');
      $.get("{{ route('anggota.index') }}" +'/' + anggota_id +'/edit', function (data) {
          $('#modelHeading').html("Edit anggota");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#anggota_id').val(data.id);
          $('#kode_Anggota').val(data.kode_Anggota);
          $('#nama').val(data.nama);
          $('#jk').val(data.jk);
          $('#jurusan').val(data.jurusan);
          $('#alamat').val(data.alamat);
      })
   });
    
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
          data: $('#anggotaForm').serialize(),
          url: "{{ route('anggota.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#anggotaForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });
    });
    
    $('body').on('click', '.deleteAnggota', function () {
     
        var anggota_id = $(this).data("id");
        confirm("Are You sure want to delete !");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('anggota.store') }}"+'/'+anggota_id,
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
