<!-- Modal -->
<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Peserta Magang</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="name" class="control-label">No. Presensi</label>
                    <input type="text" class="form-control" id="nama_peserta">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama_peserta"></div>
                </div>
                

                <div class="form-group">
                    <label class="control-label">Nama Peserta</label>
                    <input type="text" class="form-control" id="no_presensi">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-no_presensi"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">Tanggal mulai</label>
                    <input type="date" class="form-control" id="tanggal_mulai">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tanggal_mulai"></div>
                </div>

                <div class="form-group">
                    <label for="" class="control-label">Tanggal berakhir</label>
                    <input type="date" class="form-control" id="tanggal_berakhir">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tanggal_berakhir"></div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="store">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    //button create post event
    $('body').on('click', '#btn-create-post', function () {

        //open modal
        $('#modal-create').modal('show');
    });

    //action create post
    $('#store').click(function(e) {
        e.preventDefault();

        //define variable
        let nama_peserta   = $('#nama_peserta').val();
        let no_presensi = $('#no_presensi').val();
        let tanggal_mulai = $('#tanggal_mulai').val();
        let tanggal_berakhir = $('#tanggal_berakhir').val();
        let token   = $("meta[name='csrf-token']").attr("content");
        
        //ajax
        $.ajax({
            url: '/admin/peserta',
            type: "POST",
            cache: false,
            data: {
                "nama_peserta": nama_peserta,
                "no_presensi": no_presensi,
                "tanggal_mulai": tanggal_mulai,
                "tanggal_berakhir": tanggal_berakhir,
                "_token": token
            },

            success:function(response){
                console.log(response.data)
                //show success message
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    timer: 3000
                });

                //data pesertaMagang
                let pesertaMagang = `

                    <tr id="index_${response.data.id}">
                        <td>${response.data.id}</td>
                        <td>${response.data.nama_peserta}</td>
                        <td>${response.data.no_presensi}</td>
                        <td>${response.data.tanggal_mulai}</td>
                        <td>${response.data.tanggal_berakhir}</td>
                        <td>${response.data.status_peserta_aktif}</td>
                        <td>${response.data.status_akun_aplikasi}</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" id="btn-edit-post" data-id="${response.data.id}" class="btn btn-primary btn-sm">Edit</a>
                            <a href="javascript:void(0)" id="btn-delete-post" data-id="${response.data.id}" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                `;
                
                //prepend to table
                $('#table-peserta').prepend(pesertaMagang);
                
                //clear form
                $('#nama_peserta').val('');
                $('#no_presensi').val('');
                $('#tanggal_mulai').val('');
                $('#tanggal_berakhir').val('');

                //close modal
                $('#modal-create').modal('hide');
                

            },
            error:function(error){
                
                if(error.responseJSON.nama_peserta[0]) {

                    //show alert
                    $('#alert-nama_peserta').removeClass('d-none');
                    $('#alert-nama_peserta').addClass('d-block');

                    //add message to alert
                    $('#alert-nama_peserta').html(error.responseJSON.nama_peserta[0]);
                } 

                if(error.responseJSON.no_presensi[0]) {

                    //show alert
                    $('#alert-no_presensi').removeClass('d-none');
                    $('#alert-no_presensi').addClass('d-block');

                    //add message to alert
                    $('#alert-no_presensi').html(error.responseJSON.no_presensi[0]);
                } 

                if(error.responseJSON.tanggal_mulai[0]){
                    //show alert
                    $('#alert-tanggal_mulai').removeClass('d-none');
                    $('#alert-tanggal_mulai').addClass('d-block');

                    //add message to alert
                    $('#alert-tanggal_mulai').html(error.responseJSON.tanggal_mulai[0]);
                }

                if(error.responseJSON.tanggal_berakhir[0]){
                    //show alert
                    $('#alert-tanggal_berakhir').removeClass('d-none');
                    $('#alert-tanggal_berakhir').addClass('d-block');

                    //add message to alert
                    $('#alert-tanggal_berakhir').html(error.responseJSON.tanggal_berakhir[0]);
                }

            }

        });

    });

</script>