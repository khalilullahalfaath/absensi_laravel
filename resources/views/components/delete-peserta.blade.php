<body>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</body>
<script>
    // button delete peserta magang event
    $('body').on('click', '#btn-delete-peserta', function () {
        let peserta_id = $(this).data('id');
        let token   = $("meta[name='csrf-token']").attr("content");

        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/peserta/${peserta_id}`,
                    type: "DELETE",
                    cache: false,
                    data: {
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

                        //remove peserta magang
                        $(`#index_${peserta_id}`).remove();
                    },
                    error:function(response){
                        //show error message
                        Swal.fire({
                            type: 'error',
                            icon: 'error',
                            title: `${response.message}`,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                });
            }
        })
    });
</script>