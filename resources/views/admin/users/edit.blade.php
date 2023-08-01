<!-- resources/views/users/edit.blade.php -->
<form action="{{ route('admin.users.update', $user) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- Add your input fields here for editing user data -->
    <input type="text" name="nama" value="{{ $user->nama }}" required>
    <input type="email" name="email" value="{{ $user->email }}" required>

    <!-- Add other fields you want to edit... -->

    <button type="submit">Save Changes</button>
</form>
