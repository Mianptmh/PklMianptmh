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
                        <a class="btn btn-success" href="javascript:void(0)" id="buatPengembalian">Pengembalian</a>
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Kembali</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Denda Perhari</th>
                                    <th>Jumlah Hari</th>
                                    <th>Total Benda</th>
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
                                    <form id="pengembalianForm" name="pengembalianForm" class="form-horizontal">
                                       <input type="hidden" name="pengembalian_id" id="pengembalian_id">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-4 control-label">Kode Kembali</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="kode_kembali" name="kode_kembali" placeholder="" value="" maxlength="50" required="">
                                            </div>
                                        </div>
                         
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Tanggal Kembali</label>
                                            <div class="col-sm-12">
                                                <input type="date" id="tanggal_kembali" name="tanggal_kembali" required="" placeholder="" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Jatuh Tempo</label>
                                            <div class="col-sm-12">
                                                <input type="date" id="jatuh_tempo" name="jatuh_tempo" required="" placeholder="" class="form-control">
                                            </div>
                                        </div><!-- 

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Denda Perhari</label>
                                            <div class="col-sm-12">
                                                <input type="text" id="denda_perhari" name="denda_perhari" required="" placeholder="" class="form-control">
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-sm-4 control-label">Total Benda</label>
                                            <div class="col-sm-12">
                                                <input type="text" id="total_benda" name="total_benda" required="" placeholder="" class="form-control">
                                            </div>
                                        </div> -->

                                       <div class="form-group">
                                            <label class="col-sm-4 control-label">Kode Petugas</label>
                                            <div class="col-sm-12">
                                                <select type="text" class="form-control isi-petugas" id="kode_petugas" name="kode_petugas" placeholder="Masukkan Nama Petugas" value="" maxlength="50" required="">
                                                </select>
                                              </div>
                                            </div>

                                         <div class="form-group">
                                            <label class="col-sm-4 control-label">Kode Angggota</label>
                                            <div class="col-sm-12">
                                                <select type="text" class="form-control isi-anggota" id="kode_anggota" name="kode_anggota" placeholder="Masukkan Nama Petugas" value="" maxlength="50" required="">
                                                </select>
                                              </div>
                                            </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Kode Buku</label>
                                            <div class="col-sm-12">
                                                <select type="text" class="form-control isi-buku" id="kode_buku" name="kode_buku" placeholder="Masukkan Jabatan Petugas" value="" maxlength="50" required="">
                                                </select>
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
        ajax: "{{ route('pengembalian.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'kode_kembali', name: 'kode_kembali'},
            {data: 'tanggal_kembali', name: 'tanggal_kembali'},
            {data: 'jatuh_tempo', name: 'jatuh_tempo'},
            {data: 'denda_perhari', name: 'denda_perhari'},
            {data: 'jumlah_hari', name: 'jumlah_hari'},
            {data: 'total_denda', name: 'total_denda'},
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
     
    $('#buatPengembalian').click(function () {
        $('#saveBtn').val("create-product");
        $('#pengembalian_id').val('');
        $('#pengembalianForm').trigger("reset");
        $('#modelHeading').html("Create pengembalian");
        $('#ajaxModel').modal('show');
    });
    
    $('body').on('click', '.editPengembalian', function () {
      var pengembalian_id = $(this).data('id');
      $.get("{{ route('anggota.index') }}" +'/' + pengembalian_id +'/edit', function (data) {
          $('#modelHeading').html("Edit pengembalian");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#pengembalian_id').val(data.id);
          $('#kode_kembali').val(data.kode_kembali);
          $('#tanggal_kembali').val(data.tanggal_kembali);
          $('#jatuh_tempo').val(data.jatuh_tempo);
          $('#denda_perhari').val(data.denda_perhari);
          $('#kode_petugas').val(data.kode_petugas);
          $('#kode_anggota').val(data.kode_anggota);
          $('#kode_buku').val(data.kode_buku);
          $('#total_benda').val(data.total_benda);
      })
   });
    
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
          data: $('#pengembalianForm').serialize(),
          url: "{{ route('pengembalian.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#pengembalianForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });
    });
    
    $('body').on('click', '.deletePengembalian', function () {
     
        var pengembalian_id = $(this).data("id");
        confirm("Are You sure want to delete !");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('pengembalian.store') }}"+'/'+pengembalian_id,
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
