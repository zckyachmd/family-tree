<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>

    {{-- CSS Tag --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/tree.css') }}">

    {{-- JS Tag --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    {{-- Family Tree --}}
    <div class='row my-5'>
        {{-- Header --}}
        <div class='col-md-12'>
            <h2 class="text-center">Family Tree</h2>
            <p class="text-center">Klik pada nama untuk mengedit atau menghapus data.</p>
        </div>
        {{-- Visualisasi --}}
        <div class="col-md-8 d-flex justify-content-center tree mt-3">
            {{-- Tree --}}
            {!! $families !!}
        </div>
        {{-- Info Label --}}
        <div class='col-md-2'>
            <h5>Info</h5>
            <div class="d-flex">
                <div class="me-2">
                    <span class="badge bg-primary">Laki-laki</span>
                </div>
                <div class="me-2">
                    <span class="badge bg-danger">Perempuan</span>
                </div>
            </div>
            {{-- Button Add --}}
            <button class="btn btn-sm btn-outline-dark mt-3" id="btn-add">Tambah Keluarga</button>
        </div>
    </div>

    {{-- Query --}}
    <div class='row my-5 mx-auto'>
        <h4>Soal Query</h4>
        <div class='col-md-10'>
            <p>
                <b>1. </b>Query untuk menampilkan semua anak Budi.
                <br />
                <code>
                    SELECT name, gender FROM families WHERE parent_id = ( SELECT id FROM families WHERE name = 'Budi');
                </code>
            </p>
            <p>
                <b>2. </b>Query untuk menampilkan cucu dari Budi.
                <br />
                <code>
                    SELECT name,gender FROM families WHERE parent_id IN(SELECT id FROM families WHERE parent_id=(SELECT id FROM families WHERE name='Budi'));
                </code>
            </p>
            <p>
                <b>3. </b>Query untuk menampilkan cucu perempuan dari Budi.
                <br />
                <code>
                    SELECT name,gender FROM families WHERE parent_id IN(SELECT id FROM families WHERE parent_id IN(SELECT id FROM families WHERE name='Budi'))AND gender='female';
                </code>
            </p>
            <p>
                <b>4. </b>Query untuk menampilkan bibi dari Farah.
                <br />
                <code>
                    SELECT name,gender FROM families WHERE parent_id IN(SELECT id FROM families WHERE name='Budi')AND gender='female' AND id<>(SELECT parent_id FROM families WHERE name='Farah')AND parent_id<>(SELECT parent_id FROM families WHERE name='Farah');
                </code>
            </p>
            <p>
                <b>5. </b>Query untuk menampilkan sepupu laki-laki dari Hani.
                <br />
                <code>
                    SELECT name,gender FROM families WHERE parent_id IN(SELECT id FROM families WHERE parent_id=(SELECT parent_id FROM families WHERE name='Hani')AND gender='male' AND id!=(SELECT id FROM families WHERE name='Hani'));
                </code>
            </p>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="formModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action='{{ Request::url() }}' method='post' id="form-modal">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalLabel">Title Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="name" class="col-form-label">Nama:</label>
                                <input type="text" class="form-control" id="name" name="name" required />
                            </div>
                            <div class='mb-3'>
                                <label for="gender" class="col-form-label">Jenis Kelamin:</label>
                                <select class="form-select" id="gender" name="gender" required>
                                    <option selected>Pilih Jenis Kelamin</option>
                                    <option value="male">Laki-laki</option>
                                    <option value="female">Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3" id="input-parent">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger d-none" id="btn-delete">Hapus</button>
                        <button type="button" class="btn btn-success" id="btn-save">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Javascript Tag --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js">
    </script>
    <script>
        // Add Family Button
        $(document).on('touchend tap click','#btn-add', function () {
            // Set Form Action
            $('#formModal #form-modal').trigger('reset');
            $('#formModal #form-modal').attr('action', '{{ Request::url() . "/api" }}');
            $('#formModal #form-modal').attr('method', 'post');

            // Request Family Data
            family();

            // Set Modal Title
            $('#formModal .modal-title').text('Tambah Keluarga');
            $('#formModal .btn-success').text('Simpan');

            // Show Modal
            $('#formModal').modal('show');
        });

        // Edit Family Button
        $(document).on('touchend tap click','.btn-edit', function () {
            // Request family data
            family();

            // Request selected family data
            $.ajax({
                url: '{{ Request::url() }}/api/' + $(this).data('id'),
                type: 'get',
                dataType: 'json',
                success: function(response){
                    // Set Form Action
                    $('#formModal #form-modal').trigger('reset');
                    $('#formModal #form-modal').attr('action', '{{ Request::url() }}/api/' + response.data.id);
                    $('#formModal #form-modal').attr('method', 'put');

                    // Set Form Value
                    $('#formModal #name').val(response.data.name);
                    $('#formModal #gender').val(response.data.gender).change();
                    $('#formModal #parent').val(response.data.parent_id).change();

                    // Set Delete Button
                    $('#formModal .btn-danger').removeClass('d-none');
                    $('#formModal .btn-danger').attr('data-id', response.data.id);

                    // Set Modal Title
                    $('#formModal .modal-title').text('Edit Keluarga');
                    $('#formModal .btn-success').text('Simpan');

                    // Show Modal
                    $('#formModal').modal('show');
                }
            })
        });

        // Save Family Button
        $('#form-modal #btn-save').on('submit touchend tap click', function (e) {
            // Prevent Default
            event.preventDefault();

            // Save Family
            $.ajax({
                url: $('#formModal #form-modal').attr('action'),
                type: $('#formModal #form-modal').attr('method'),
                data: $('#formModal #form-modal').serialize(),
                dataType: 'json',
                success: function(response) {
                    // Hide Modal
                    $('#formModal').modal('hide');

                    // Reload Page
                    location.reload();
                },
                error: function(response) {
                    // Alert Error
                    alert(response.responseJSON.message);
                }
            });
        });

        // Delete Family Button
        $('#formModal #btn-delete').on('click', function (e) {
            // Confirm Delete
            if (confirm('Apakah anda yakin ingin menghapus data ini?')) {
                // Delete Family
                $.ajax({
                    url: '{{ Request::url() }}/api/' + $(this).data('id'),
                    type: 'delete',
                    dataType: 'json',
                    success: function(response) {
                        // Hide Modal
                        $('#formModal').modal('hide');

                        // Reload Page
                        location.reload();
                    },
                    error: function(response) {
                        // Alert Error
                        alert(response.responseJSON.message);
                    }
                });
            }
        });

        // Request Family Data
        function family() {
            // Request Parent Data
            $.ajax({
                url: '{{ Request::url() }}/api',
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    let html = '';

                    // Create Parent Input
                    html += '<label for="parent" class="col-form-label">Parent:</label>';
                    html += '<select class="form-select" id="parent" name="parent" required>';
                    html += '<option value="" selected>Pilih Orang Tua</option>';
                    $.each(response.data, function(key, value) {
                        html += '<option value="' + value.id + '">' + value.name + '</option>';
                    });
                    html += '</select>';

                    // Set Parent Input
                    $('#formModal #input-parent').html(html);
                },
                error: function(response) {
                    // Alert Error
                    alert(response.responseJSON.message);
                }
            });
        }
    </script>
</body>

</html>
