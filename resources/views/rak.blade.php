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
                        <a class="btn btn-success" href="javascript:void(0)" id="buatRak">Rak</a>
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Rak</th>
                                    <th>Nama Rak</th>
                                    <th>Kode Buku</th>
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
                                    <form id="rakForm" name="rakForm" class="form-horizontal">
                                       <input type="hidden" name="rak_id" id="rak_id">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-4 control-label">Kode Rak</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="kode_rak" name="kode_rak" placeholder="" value="" maxlength="50" required="">
                                            </div>
                                        </div>
                         
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Nama Rak</label>
                                            <div class="col-sm-12">
                                                <input type="text" id="nama_rak" name="nama_rak" required="" placeholder="" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Kode Buku</label>
                                            <div class="col-sm-12">
                                                <select type="text" class="form-control isi-buku" id="kode_buku" name="kode_buku" placeholder="Masukkan Jabatan Petugas" value="" maxlength="50" required="">
                                                </select>
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
        ajax: "{{ route('rak.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'kode_rak', name: 'kode_rak'},
            {data: 'nama_rak', name: 'nama_rak'},
            {data: 'kode_buku', name: 'kode_buku'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $.ajax({
    url: "{{ url('buku') }}",
    method: "GET",
    dataType: "json",
    
    success: function (berhasil) {
        // console.log(berhasil)
        $.each(berhasil.data, function (key, value) {
            $(".isi-buku").append(
                `
                <option value="${value.id}">
                    ${value.kode_buku}
                </option>        
                `
            )
        }) 
    }
})

$.ajax({
    url: "{{ url('petugas') }}",
    method: "GET",
    dataType: "json",
    
    success: function (berhasil) {
        // console.log(berhasil)
        $.each(berhasil.data, function (key, value) {
            $(".isi-petugas").append(
                `
                <option value="${value.id}">
                    ${value.kode_petugas}
                </option>        
                `
            )
        }) 
    }
})

$.ajax({
    url: "{{ url('anggota') }}",
    method: "GET",
    dataType: "json",
    
    success: function (berhasil) {
        // console.log(berhasil)
        $.each(berhasil.data, function (key, value) {
            $(".isi-anggota").append(
                `
                <option value="${value.id}">
                    ${value.kode_anggota}
                </option>        
                `
            )
        }) 
    }
})

$.ajax({
    url: "{{ url('rak') }}",
    method: "GET",
    dataType: "json",
    
    success: function (berhasil) {
        // console.log(berhasil)
        $.each(berhasil.data, function (key, value) {
            $(".isi-anggota").append(
                `
                <option value="${value.id}">
                    ${value.kode_anggota}
                </option>        
                `
            )
        }) 
    }
})

    $('#buatRak').click(function () {
        $('#saveBtn').val("create-product");
        $('#rak_id').val('');
        $('#rakForm').trigger("reset");
        $('#modelHeading').html("Create New rak");
        $('#ajaxModel').modal('show');
    });
    
    $('body').on('click', '.editRak', function () {
      var rak_id = $(this).data('id');
      $.get("{{ route('rak.index') }}" +'/' + rak_id +'/edit', function (data) {
          $('#modelHeading').html("Edit rak");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#rak_id').val(data.id);
          $('#kode_rak').val(data.kode_rak);
          $('#nama_rak').val(data.nama_rak);
          $('#kode_buku').val(data.kode_buku);
      })
   });
    
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
          data: $('#rakForm').serialize(),
          url: "{{ route('rak.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#rakForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });
    });
    
    $('body').on('click', '.deleteRak', function () {
     
        var rak_id = $(this).data("id");
        confirm("Are You sure want to delete !");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('rak.store') }}"+'/'+rak_id,
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
