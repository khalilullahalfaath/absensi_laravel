<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function updateUser(Request $request, $id)
    {

        // Validate the form data as needed
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'no_presensi' => 'required|string|max:255|unique:users,no_presensi,' . $id,
            'asal_instansi' => 'required|string|max:255',
            'nama_unit_kerja' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
        ]);

        // Find the user record to update
        $user = User::findOrFail($id);

        // Update the user record with the new data
        $user->update($validatedData);

        // Redirect back to the main view after updating
        return redirect()->route('admin.users')->with('success', 'User record updated successfully!');
    }

    public function destroy($id)
    {
        $user = User::where('id', $id)
            ->delete();

        return redirect()->route('admin.users')->with('success', 'User record deleted successfully!');
    }



    public function showAllData()
    {

        // select *  from users where role = 'user'
        $userRecords = User::where('role', 'user')->get();
        return view('admin.pages.data_siswa', compact('userRecords'));
    }

    public function printAllUsersToCSV()
    {
        $users = User::where('role', 'user')->get();

        $csvData = "Nama,Email,No. Presensi,Asal Instansi,Nama Unit Kerja,Jenis Kelamin,Tanggal Lahir\n";

        foreach ($users as $user) {
            $csvData .= "{$user->nama},{$user->email},{$user->no_presensi},{$user->asal_instansi},{$user->nama_unit_kerja},{$user->jenis_kelamin},{$user->tanggal_lahir}\n";
        }

        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=Users_record.csv',
        ];


        return response($csvData, 200, $headers);
    }
}
