<!-- Main view displaying the user records -->
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <!-- Table header -->
            <tr>
                <th>No.</th>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No. Presensi</th>
                <th>Asal Instansi</th>
                <th>Nama Unit Kerja</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($userRecords as $userRecord)
            <tr id="user_{{ $userRecord->id }}">
                <!-- Display user record data -->
                <td data-field="no">{{ $loop->iteration }}</td>
                <td data-field="id">{{ $userRecord->id }}</td>
                <td data-field="nama">{{ $userRecord->nama }}</td>
                <td data-field="email">{{ $userRecord->email }}</td>
                <td data-field="no_presensi">{{ $userRecord->no_presensi }}</td>
                <td data-field="asal_instansi">{{ $userRecord->asal_instansi }}</td>
                <td data-field="nama_unit_kerja">{{ $userRecord->nama_unit_kerja }}</td>
                <td data-field="jenis_kelamin">{{ $userRecord->jenis_kelamin }}</td>
                <td data-field="tanggal_lahir">{{ $userRecord->tanggal_lahir }}</td>
                <td>
                    <!-- Edit button -->
                    <button class="btn btn-primary edit-btn" data-userid="{{ $userRecord->id }}">Edit</button>
            
                    <!-- Delete button -->
                    <button class="btn btn-danger delete-btn" onclick="confirmDelete('{{ route('admin.users.destroy', $userRecord) }}')">Delete</button>

                    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-3 d-flex justify-content-center">
    <a href="{{ route('print.students.csv') }}" class="btn btn-primary">Download Student Records</a>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User Record</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Edit form fields go here -->
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="edit_nama">Nama</label>
                        <input type="text" class="form-control" id="edit_nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_no_presensi">No presensi</label>
                        <input type="text" name="no_presensi" class="form-control" id="edit_no_presensi"  required>
                    </div>
                    <div class="form-group">
                        <label for="edit_asal_instansi">Asal Instansi</label>
                        <input type="text" name="asal_instansi" id="edit_asal_instansi" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_nama_unit_kerja">Nama Unit Kerja</label>
                        <input type="text" name="nama_unit_kerja" id="edit_nama_unit_kerja" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_jenis_kelamin">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control" id="edit_jenis_kelamin" required>
                            <option value="">Pilih jenis kelamin</option>
                            <option value="Male">Laki-laki</option>
                            <option value="Female">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="edit_tanggal_lahir"  class="form-control" required>
                    

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveChangesBtn">Save Changes</button>
            </div>
        </div>
    </div>
</div>






