<?php

namespace App\Http\Controllers;

use App\Models\AbsensiCheckIn;
use App\Models\AbsensiCheckOut;
use App\Models\Record;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    function index()
    {
        return view('admin/index');
    }

    public function adminAttendance()
    {

        // Get all check-in records
        $checkInRecords = AbsensiCheckIn::all();

        // Get all check-out records
        $checkOutRecords = AbsensiCheckOut::all();

        // Get all records
        $records = Record::all();

        return view('admin.pages.attendances.data_attendance', compact('checkInRecords', 'checkOutRecords', 'records'));
    }

    public function searchUsers(Request $request)
    {
        // Get the search query from the request
        $searchQuery = $request->input('search');

        // Search for users based on the search query
        $users = User::where('nama', 'like', "%$searchQuery%")
            ->orWhere('email', 'like', "%$searchQuery%")
            ->get();

        return view('admin.pages.attendances.search', compact('users'));
    }

    public function destroyCheckIn($id)
    {
        // Find the Check-in record by its ID
        $checkInRecord = AbsensiCheckIn::findOrFail($id);

        // Check if there are associated records in the "records" table
        $associatedRecords = Record::where('absensi_check_in_id', $id)->get();

        if ($associatedRecords->isNotEmpty()) {
            // If there are associated records, delete them first
            foreach ($associatedRecords as $record) {
                $record->delete();
            }
        }

        // Now, you can delete the Check-in record
        $checkInRecord->delete();

        // Redirect back to the main view with a success message
        return redirect('admin/attendance')->with('success', 'Check-in record deleted successfully.');
    }

    public function destroyCheckOut($id)
    {
        // Find the Check-out record by its ID
        $checkOutRecord = AbsensiCheckOut::findOrFail($id);

        // Check if there are associated records in the "records" table
        $associatedRecords = Record::where('absensi_check_out_id', $id)->get();

        if ($associatedRecords->isNotEmpty()) {
            // If there are associated records, delete them first
            foreach ($associatedRecords as $record) {
                $record->delete();
            }
        }

        // Now, you can delete the Check-out record
        $checkOutRecord->delete();

        // Redirect back to the main view with a success message
        return redirect('admin/attendance')->with('success', 'Check-out record deleted successfully.');
    }

    public function destroyRecord($id)
    {
        // Find the record by its ID
        $record = Record::findOrFail($id);

        // Delete the record
        $record->delete();

        // Redirect back to the main view with a success message
        return redirect('admin/attendance')->with('success', 'Record deleted successfully.');
    }

    public function printAllCheckinRecordsToCSV()
    {
        $checkInRecords = AbsensiCheckIn::all();

        $csvData = "No, Id_user, tanggal_presensi, jam_masuk\n";

        foreach ($checkInRecords as $key => $checkInRecord) {
            $csvData .= $key + 1 . ", " . $checkInRecord->user_id . ", " . $checkInRecord->tanggal_presensi . ", " . $checkInRecord->jam_masuk . "\n";
        }

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="checkin_records.csv"',
        ];

        return response($csvData, 200, $headers);
    }

    public function printAllCheckoutRecordsToCSV()
    {
        $checkOutRecords = AbsensiCheckOut::all();

        $csvData = "No, Id_user, tanggal_presensi, jam_keluar\n";

        foreach ($checkOutRecords as $key => $checkOutRecord) {
            $csvData .= $key + 1 . ", " . $checkOutRecord->user_id . ", " . $checkOutRecord->tanggal_presensi . ", " . $checkOutRecord->jam_keluar . "\n";
        }

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="checkout_records.csv"',
        ];

        return response($csvData, 200, $headers);
    }

    public function printAllRecordsToCSV()
    {
        $records = Record::all();

        $csvData = "No, Id_user, tanggal_presensi, jam_masuk, jam_keluar, jam_kerja\n";

        foreach ($records as $key => $record) {
            $csvData .= $key + 1 . ", " . $record->user_id . ", " . $record->tanggal_presensi . ", " . $record->jam_masuk . ", " . $record->jam_keluar . "," . $record->jam_kerja . "\n";
        }

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="records.csv"',
        ];

        return response($csvData, 200, $headers);
    }
}
