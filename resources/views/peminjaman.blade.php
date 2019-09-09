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
                        <a class="btn btn-success" href="javascript:void(0)" id="buatPeminjaman">Peminjaman</a>
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Pinjam</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Kode Petugas</th>
                                    <th>Kode Anggota</th>
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
                                    <form id="peminjamanForm" name="peminjamanForm" class="form-horizontal">
                                       <input type="hidden" name="peminjaman_id" id="peminjaman_id">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-3 control-label">Kode Pinjam</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="kode_pinjam" name="kode_pinjam" placeholder="" value="" maxlength="50" required="">
                                            </div>
                                        </div>
                         
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Tanggal Pinjam</label>
                                            <div class="col-sm-12">
                                                <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" required="" placeholder="" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Tanggal Kembali</label>
                                            <div class="col-sm-12">
                                                <input type="date" id="tanggal_kembali" name="tanggal_kembali" required="" placeholder="" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Kode Petugas</label>
                                            <div class="col-sm-12">
                                                 <select type="text" class="form-control isi-petugas" id="kode_petugas" name="kode_petugas" placeholder="" value="" maxlength="50" required="">
                            </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Kode Anggota</label>
                                            <div class="col-sm-12">
                                               <select type="text" class="form-control isi-anggota" id="kode_anggota" name="kode_anggota" placeholder="" value="" maxlength="50" required="">
                                </select>
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-sm-3 control-label">Kode Buku</label>
                                            <div class="col-sm-12">
                                                <select type="text" class="form-control isi-buku" id="kode_buku" name="kode_buku" placeholder="" value="" maxlength="50" required="">
                                                </select>
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
        ajax: "{{ route('peminjaman.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'kode_pinjam', name: 'kode_pinjam'},
            {data: 'tanggal_pinjam', name: 'tanggal_pinjam'},
            {data: 'tanggal_kembali', name: 'tanggal_kembali'},
            {data: 'petugas.kode_petugas', name: 'kode_petugas'},
            {data: 'anggota.kode_anggota', name: 'kode_anggota'},
            {data: 'buku.kode_buku', name: 'kode_buku'},
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


    $('#buatPeminjaman').click(function () {
        $('#saveBtn').val("create-product");
        $('#peminjaman_id').val('');
        $('#peminjamanForm').trigger("reset");
        $('#modelHeading').html("Create Peminjaman");
        $('#ajaxModel').modal('show');
    });
    
    $('body').on('click', '.editPeminjaman', function () {
      var peminjaman_id = $(this).data('id');
      $.get("{{ route('peminjaman.index') }}" +'/' + peminjaman_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Peminjaman");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#peminjaman_id').val(data.id);
          $('#kode_pinjam').val(data.kode_pinjam);
          $('#tanggal_pinjam').val(data.tanggal_pinjam);
          $('#tanggal_kembali').val(data.tanggal_kembali);
          $('#kode_petugas').val(data.kode_petugas);
          $('#kode_anggota').val(data.kode_anggota);
          $('#kode_buku').val(data.kode_buku);
      })
   });
    
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
          data: $('#peminjamanForm').serialize(),
          url: "{{ route('peminjaman.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#peminjamanForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });
    });
    
    $('body').on('click', '.deletePeminjaman', function () {
     
        var peminjaman_id = $(this).data("id");
        confirm("Are You sure want to delete !");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('peminjaman.store') }}"+'/'+peminjaman_id,
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
