<!-- Modal -->
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="edit-form"> <!-- Add the form element here -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Peserta Magang</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="peserta_id">
                    <div class="form-group">
                        <label for="name" class="control-label">No. Presensi</label>
                        <input type="text" class="form-control" id="no_presensi-edit">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-no_presensi-edit"></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Nama Peserta</label>
                        <input type="text" class="form-control" id="nama_peserta-edit">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama_peserta-edit"></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Tanggal mulai</label>
                        <input type="date" class="form-control" id="tanggal_mulai-edit">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tanggal_mulai-edit"></div>
                    </div>

                    <div class="form-group">
                        <label for="" class="control-label">Tanggal berakhir</label>
                        <input type="date" class="form-control" id="tanggal_berakhir-edit">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tanggal_berakhir-edit"></div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="status_peserta-edit" class="control-label">Status Peserta Aktif</label>
                        <input type="checkbox" class="form-check-input" id="status_peserta-edit" name="status_peserta_edit">
                    </div>
                    <div class="form-group mt-3">
                        <label for="status_aplikasi-edit" class="control-label">Status Akun Aplikasi Aktif</label>
                        <input type="checkbox" class="form-check-input" id="status_aplikasi-edit" name="status_aplikasi-edit">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="update">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function displayAlertEdit(field, message) {
    if (message) {
        var alertElement = $('#alert-' + field + '-edit');
        alertElement.removeClass('d-none').addClass('d-block').html(message);
     }
    }

    //button create post event
    $('body').on('click', '#btn-edit-peserta', function () {

        let peserta_id = $(this).data('id');

        // fetch detail data with ajax
        $.ajax({
            url: `/admin/peserta/${peserta_id}`,
            type: "GET",
            cache: false,
            success:function(response){
                
                //set value to modal
                $('#peserta_id').val(response.data.id);
                $('#no_presensi-edit').val(response.data.no_presensi);
                $('#nama_peserta-edit').val(response.data.nama_peserta);
                $('#tanggal_mulai-edit').val(response.data.tanggal_mulai);
                $('#tanggal_berakhir-edit').val(response.data.tanggal_berakhir);
                $('#status_peserta-edit').prop('checked', response.data.status_peserta_aktif == 1 ? true : false);
                $('#status_aplikasi-edit').prop('checked', response.data.status_akun_aplikasi == 1 ? true : false);

                //open modal
                $('#modal-edit').modal('show');
            },
            error:function(error){
                console.log(error);
            }
        });
    });

    $('#modal-edit').on('hidden.bs.modal', function () {
        $(this).find('form').trigger('reset');
        $('#alert-no_presensi-edit').removeClass('d-block');
        $('#alert-no_presensi-edit').addClass('d-none');
        $('#alert-nama_peserta-edit').removeClass('d-block');
        $('#alert-nama_peserta-edit').addClass('d-none');
        $('#alert-tanggal_mulai-edit').removeClass('d-block');
        $('#alert-tanggal_mulai-edit').addClass('d-none');
        $('#alert-tanggal_berakhir-edit').removeClass('d-block');
        $('#alert-tanggal_berakhir-edit').addClass('d-none');
    })


    //action edit post
    $('#update').click(function(e) {
        e.preventDefault();

        $('#alert-no_presensi-edit').removeClass('d-block').addClass('d-none').html('');
        $('#alert-nama_peserta-edit').removeClass('d-block').addClass('d-none').html('');
        $('#alert-tanggal_mulai-edit').removeClass('d-block').addClass('d-none').html('');
        $('#alert-tanggal_berakhir-edit').removeClass('d-block').addClass('d-none').html('');

        //define variable
        let peserta_id = $('#peserta_id').val();
        let nama_peserta   = $('#nama_peserta-edit').val();
        let no_presensi = $('#no_presensi-edit').val();
        let tanggal_mulai = $('#tanggal_mulai-edit').val();
        let tanggal_berakhir = $('#tanggal_berakhir-edit').val();
        let status_peserta_aktif = $('#status_peserta-edit').prop('checked') == true ? 1 : 0;
        let status_akun_aplikasi = $('#status_aplikasi-edit').prop('checked') == true ? 1 : 0;
        let token   = $("meta[name='csrf-token']").attr("content");
        
        //ajax
        $.ajax({
            url: `/admin/peserta/${peserta_id}`,
            type: "PUT",
            cache: false,
            data: {
                "nama_peserta": nama_peserta,
                "no_presensi": no_presensi,
                "tanggal_mulai": tanggal_mulai,
                "tanggal_berakhir": tanggal_berakhir,
                "status_peserta_aktif": status_peserta_aktif,
                "status_akun_aplikasi": status_akun_aplikasi,
                "_token": token
            },

            success:function(response){
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
                    <td></td>
                    <td>${response.data.no_presensi}</td>
                    <td>${response.data.nama_peserta}</td>
                    <td>${response.data.tanggal_mulai}</td>
                    <td>${response.data.tanggal_berakhir}</td>
                    <td>
                        <button class="btn ${response.data.status_peserta_aktif == 1 ? 'btn-success' : 'btn-danger'}">
                            ${response.data.status_peserta_aktif == 1 ? 'Aktif' : 'Tidak Aktif'}
                        </button>
                    </td>
                    <td>
                        <button class="btn ${response.data.status_akun_aplikasi == 1 ? 'btn-success' : 'btn-danger'}">
                            ${response.data.status_akun_aplikasi == 1 ? 'Aktif' : 'Tidak Aktif'}
                        </button>
                    </td>
                    <td class="text-center">
                        <a href="javascript:void(0)" id="btn-edit-peserta" data-id="${response.data.id}" class="btn btn-primary btn-sm">Edit</a>
                        <a href="javascript:void(0)" id="btn-delete-peserta" data-id="${response.data.id}" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            `;
                
                // append to table
                $('#index_' + response.data.id).replaceWith(pesertaMagang);
                

                //close modal
                $('#modal-edit').modal('hide');
            },
            error:function(error){
                if (error.responseJSON) {
                    // show error message for tanggal_masuk > tanggal_keluar
                    console.log(error.responseJSON);

                    displayAlertEdit('no_presensi', error.responseJSON.no_presensi && error.responseJSON.no_presensi[0]);
                    displayAlertEdit('nama_peserta', error.responseJSON.nama_peserta && error.responseJSON.nama_peserta[0]);
                    displayAlertEdit('tanggal_mulai', error.responseJSON.tanggal_mulai && error.responseJSON.tanggal_mulai[0]);
                    displayAlertEdit('tanggal_berakhir', error.responseJSON.tanggal_berakhir && error.responseJSON.tanggal_berakhir[0]);
        }

            }

        });

    });

</script>