<?php

namespace App\Http\Controllers;

use App\Models\AbsensiCheckIn;
use App\Models\AbsensiCheckOut;
use App\Models\Record;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

        // Get unique absensi_check_out_id values from associated records
        $checkOutIds = $associatedRecords->pluck('absensi_check_out_id')->unique();

        // dd($checkOutIds);

        // Loop through the unique absensi_check_out_id values and delete associated records and Check-out records
        foreach ($checkOutIds as $checkOutId) {
            // Get the Check-out record by its ID
            $checkOutRecord = AbsensiCheckOut::find($checkOutId);

            // Check if the Check-out record exists and delete it
            if ($checkOutRecord) {
                // Check if there are associated records in the "records" table for the Check-out record
                $associatedCheckOutRecords = Record::where('absensi_check_out_id', $checkOutId)->get();

                // Delete associated records for the Check-out record
                foreach ($associatedCheckOutRecords as $record) {
                    $record->delete();
                }

                // Now, you can delete the Check-out record
                $checkOutRecord->delete();
            }
        }

        // Delete associated records in the "records" table
        foreach ($associatedRecords as $record) {
            $record->delete();
        }

        // Now, you can delete the Check-in record
        $checkInRecord->delete();

        // Redirect back to the main view with a success message
        return redirect('admin/attendance')->with('success', 'Check-in record and associated records deleted successfully.');
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
        // destroy checkin record
        $checkInRecord = AbsensiCheckIn::findOrFail($id);
        $checkInRecord->delete();

        // destroy checkout record
        $checkOutRecord = AbsensiCheckOut::findOrFail($id);
        $checkOutRecord->delete();

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

        $csvData = "No, Id_user, nama_peserta, tanggal_presensi, jam_masuk, status\n";

        foreach ($checkInRecords as $key => $checkInRecord) {
            $csvData .= $key + 1 . ", " . $checkInRecord->user_id . ", " . $checkInRecord->user->nama . ", " . $checkInRecord->tanggal_presensi . ", " . $checkInRecord->jam_masuk .  ", " . $checkInRecord->status . "\n";
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

        $csvData = "No, Id_user, nama_peserta, tanggal_presensi, jam_masuk, jam_keluar, jam_kerja, status_check_in\n";

        foreach ($records as $key => $record) {
            $csvData .= $key + 1 . ", " . $record->user_id . ", " . $record->user->nama . ", " . $record->absensiCheckIn->tanggal_presensi . ", "  . $record->absensiCheckIn->jam_masuk . ", " . $record->absensiCheckout->jam_keluar . "," . $record->jam_kerja  . $record->absensiCheckIn->status . "\n";
        }

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="records.csv"',
        ];

        return response($csvData, 200, $headers);
    }

    function printToCSVAdvanced()
    {
        return view('admin.pages.attendances.exports');
    }

    function printToCSVAdvancedExports(Request $request)
    {
        // Get the data from the form
        // export based on the name, start date, end date, include check-in data, checkout data, or records table or some of them or all of them
        // if the user wants to export more then one type, then the csv file will have more then one pages

        // dd($request->all());

        // Get the data from the form
        $name = request('name');
        $startDate = request('start_date');
        $endDate = request('end_date');
        $includeCheckInData = request('include_check_in');
        $includeCheckOutData = request('include_check_out');
        $includeRecordsData = request('include_records');

        // dd($name, $startDate, $endDate, $includeCheckInData, $includeCheckOutData, $includeRecordsTableData);

        // Check if the user wants to export the check-in data
        // find by name in column name and date
        // note that there is no column name but it has relation to users table

        // Build the query for check-in records based on user's input
        $checkInQuery = AbsensiCheckIn::query()
            ->whereHas('user', function ($query) use ($name) {
                $query->where('nama', 'like', '%' . $name . '%');
            })
            ->when($startDate, function ($query) use ($startDate) {
                $query->where('tanggal_presensi', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->where('tanggal_presensi', '<=', $endDate);
            });

        // Build the query for check-out records based on user's input
        $checkOutQuery = AbsensiCheckOut::query()
            ->whereHas('user', function ($query) use ($name) {
                $query->where('nama', 'like', '%' . $name . '%');
            })
            ->when($startDate, function ($query) use ($startDate) {
                $query->where('tanggal_presensi', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->where('tanggal_presensi', '<=', $endDate);
            });

        // Build the query for records table based on user's input
        $recordsQuery = Record::query()
            ->whereHas('user', function ($query) use ($name) {
                $query->where('nama', 'like', '%' . $name . '%');
            })
            ->when($startDate, function ($query) use ($startDate) {
                $query->whereHas('absensiCheckIn', function ($subQuery) use ($startDate) {
                    $subQuery->where('tanggal_presensi', '>=', $startDate);
                });
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->whereHas('absensiCheckIn', function ($subQuery) use ($endDate) {
                    $subQuery->where('tanggal_presensi', '<=', $endDate);
                });
            });

        $csvData = "";

        if ($includeCheckInData) {
            $checkInRecords = $checkInQuery->get();
            $csvData .= "Check-in Records\n";
            $csvData .= "No, Id_user, nama_peserta, tanggal_presensi, jam_masuk, status\n";
            foreach ($checkInRecords as $key => $checkInRecord) {
                $csvData .= $key + 1 . ", " . $checkInRecord->user_id . ", " . $checkInRecord->user->nama . ", " . $checkInRecord->tanggal_presensi . ", " . $checkInRecord->jam_masuk .  ", " . $checkInRecord->status . "\n";
            }
            $csvData .= "\n";
        }

        if ($includeCheckOutData) {
            $checkOutRecords = $checkOutQuery->get();
            $csvData .= "Check-in Records\n";
            $csvData .= "No, Id_user, nama_peserta, tanggal_presensi, jam_masuk, status\n";
            foreach ($checkOutRecords as $key => $checkOutRecord) {
                $csvData .= $key + 1 . ", " . $checkOutRecord->user_id . ", " . $checkOutRecord->user->nama . ", " . $checkOutRecord->tanggal_presensi . ", " . $checkOutRecord->jam_keluar .  ", " . $checkOutRecord->status . "\n";
            }
            $csvData .= "\n";
        }

        if ($includeRecordsData) {
            $records = $recordsQuery->get();
            $csvData .= "Records\n";
            $csvData .= "No, Id_user, nama_peserta, tanggal_presensi, jam_masuk, jam_keluar, jam_kerja, status_check_in\n";
            foreach ($records as $key => $record) {
                $csvData .= $key + 1 . ", " . $record->user_id . ", " . $record->user->nama . ", " . $record->absensiCheckIn->tanggal_presensi . ", "  . $record->absensiCheckIn->jam_masuk . ", " . $record->absensiCheckout->jam_keluar . "," . $record->jam_kerja  . $record->absensiCheckIn->status . "\n";
            }
            $csvData .= "\n";
        }

        if (empty($csvData)) {
            return redirect()->back()->with('error', 'No export options selected.');
        }

        // Create a filename based on selected options
        $filename = '';
        if ($name) {
            $filename .= Str::slug($name) . '_';
        }
        if ($startDate) {
            $filename .= 'from_' . str_replace('-', '', $startDate) . '_';
        }
        if ($endDate) {
            $filename .= 'to_' . str_replace('-', '', $endDate) . '_';
        }

        if ($includeCheckInData) {
            $filename .= 'checkin_';
        }
        if ($includeCheckOutData) {
            $filename .= 'checkout_';
        }
        if ($includeRecordsData) {
            $filename .= 'records_';
        }

        $filename .= 'exported_data.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response($csvData, 200, $headers);
    }
}
