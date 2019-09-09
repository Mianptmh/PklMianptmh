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
                        <a class="btn btn-success" href="javascript:void(0)" id="buatBuku">Buku</a>
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Buku</th>
                                    <th>Judul</th>
                                    <th>Penulis</th>
                                    <th>Penerbit</th>
                                    <th>Tahun Terbit</th>
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
                                    <form id="bukuForm" name="bukuForm" class="form-horizontal">
                                       <input type="hidden" name="buku_id" id="buku_id">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-3 control-label">Kode Buku</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="kode_buku" name="kode_buku" placeholder="Enter kode buku" value="" maxlength="50" required="">
                                            </div>
                                        </div>
                         
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Judul</label>
                                            <div class="col-sm-12">
                                                <input type="text" id="judul" name="judul" required="" placeholder="Enter judul" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Penulis</label>
                                            <div class="col-sm-12">
                                                <input type="text" id="penulis" name="penulis" required="" placeholder="Enter penulis" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Penerbit</label>
                                            <div class="col-sm-12">
                                                <input type="text" id="penerbit" name="penerbit" required="" placeholder="Enter penerbit" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Tahun Terbit</label>
                                            <div class="col-sm-12">
                                                <input type="text" id="tahun_terbit" name="tahun_terbit" required="" placeholder="Enter tahun terbit" class="form-control">
                                            </div>
                                        </div>
                          
                                        <div class="col-sm-offset-2 col-sm-10">
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
        ajax: "{{ route('buku.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'kode_buku', name: 'kode_buku'},
            {data: 'judul', name: 'judul'},
            {data: 'penulis', name: 'penulis'},
            {data: 'penerbit', name: 'penerbit'},
            {data: 'tahun_terbit', name: 'tahun_terbit'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
     
    $('#buatBuku').click(function () {
        $('#saveBtn').val("create-product");
        $('#buku_id').val('');
        $('#bukuForm').trigger("reset");
        $('#modelHeading').html("Create New Product");
        $('#ajaxModel').modal('show');
    });
    
    $('body').on('click', '.editBuku', function () {
      var buku_id = $(this).data('id');
      $.get("{{ route('buku.index') }}" +'/' + buku_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Buku");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#buku_id').val(data.id);
          $('#kode_buku').val(data.kode_buku);
          $('#judul').val(data.judul);
          $('#penulis').val(data.penulis);
          $('#penerbit').val(data.penerbit);
          $('#tahun_terbit').val(data.tahun_terbit);
      })
   });
    
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
          data: $('#bukuForm').serialize(),
          url: "{{ route('buku.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#bukuForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });
    });
    
    $('body').on('click', '.deleteBuku', function () {
     
        var buku_id = $(this).data("id");
        confirm("Are You sure want to delete !");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('buku.store') }}"+'/'+buku_id,
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
