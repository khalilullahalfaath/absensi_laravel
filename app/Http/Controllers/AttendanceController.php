<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AbsensiCheckIn;
use App\Models\AbsensiCheckOut;
use App\Models\Record;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    function attendance()
    {
        // Menampilkan form register
        return view('attendance.index');
    }

    public function create(Request $request)
{
    // Get the attendance type from the request
    $attendanceType = $request->input('attendance_type');

    // Check if the attendance type is 'checkin' or 'checkout'
    if ($attendanceType === 'checkin') {
        $result = $this->checkIn($request);
    } elseif ($attendanceType === 'checkout') {
        $result = $this->checkOut($request);

        if (!$result['success']) {
            // dd('Masuk');
            // dd($result);
            return redirect('home')->withErrors($result['message']);
        }
    } else {
        // If an invalid attendance type is provided, redirect back with an error message
        return redirect('attendance')->withErrors('Invalid attendance type.');
    }

    // dd($result);

    if ($result['success']) {
        // if success
        return redirect('home')->with('success', 'absensi berhasil');
    } else {
        return redirect('home')->withErrors($result['message']);
    }
}


    public function checkIn(Request $request)
    {
    // Get the current date and time
    $currentDateTime = now();

    // Parse the input date and time from the request
    $inputDate = $request->date;
    $inputTime = $request->time;

    // Combine the input date and time and create a DateTime object
    $inputDateTime = \DateTime::createFromFormat('Y-m-d H:i', "{$inputDate} {$inputTime}");

    // Check if the input date and time are valid
    if (!$inputDateTime || $inputDateTime->format('Y-m-d H:i') !== "{$inputDate} {$inputTime}") {
        return ['success' => false, 'message' => 'Invalid date or time format.'];
    }

    // Check if the input date and time are after the current date and time
    if ($inputDateTime > $currentDateTime) {
        return ['success' => false, 'message' => 'Cannot check in for future dates.'];
    }

    // Set the date portion of the $sixAM DateTime object to be the same as the input date
    $sixAM = \DateTime::createFromFormat('Y-m-d H:i', "{$inputDate} 06:00");

    // Check if the input time is before 6 AM
    if ($inputDateTime < $sixAM) {
        return ['success' => false, 'message' => 'You can only check in after 6 AM.'];
    }

    // Store check-in data
    $checkInData = [
        'tanggal_presensi' => $request->date,
        'jam_masuk' => $request->time,
        'user_id' => Auth::id(),
    ];

    AbsensiCheckIn::create($checkInData);

    return ['success' => true, 'message' => 'Check-in successful'];
    }

    public function checkOut(Request $request)
    {
        // Find the corresponding check-in record for the given date and user
        $checkInRecord = AbsensiCheckIn::where('user_id', Auth::id())
        ->where('tanggal_presensi', $request->date)
        ->first();

        // Check if a check-in record was found
        if ($checkInRecord) {
        // Store check-out data
        $checkOutData = [
            'tanggal_presensi' => $request->date,
            'jam_keluar' => $request->time,
            'user_id' => Auth::id(),
        ];

        $checkOutRecord = AbsensiCheckOut::create($checkOutData);

        $checkintime = $checkInRecord->jam_masuk;
        $checkouttime = $checkOutRecord->jam_keluar;

        // Calculate work hours and store in records table
        $workHours = $this->calculateWorkHours($checkintime, $checkouttime);

        $recordData = [
            'user_id'  => Auth::id(),  
            'absensi_check_in_id' => $checkInRecord->id,
            'absensi_check_out_id' => $checkOutRecord->id,
            'jam_kerja' => $workHours,
        ];

        Record::create($recordData);

        // dd($recordData);
        return ['success' => true, 'message' => 'Check-out successful'];
        } else {
        // If no corresponding check-in found, redirect back with an error message
        // dd("HALO MASUK DI SINI");
        return ['success' => false, 'message' => 'Check-out unsuccessful. Please check if you have checkin for today.'];
        }
    }

    private function calculateWorkHours($checkInTime, $checkOutTime)
{
    $checkInTime = strtotime($checkInTime);
    $checkOutTime = strtotime($checkOutTime);

    // Calculate the difference in seconds
    $workHoursInSeconds = $checkOutTime - $checkInTime;

    // Convert to hours and minutes format (HH:mm)
    $hours = floor($workHoursInSeconds / 3600);
    $minutes = floor(($workHoursInSeconds % 3600) / 60);

    return sprintf('%02d:%02d', $hours, $minutes);
}

public function showAllData()
{
    $userId = Auth::id();

    // Retrieve all check-in records for the authenticated user
    $checkInRecords = AbsensiCheckIn::where('user_id', $userId)->get();

    // Retrieve all check-out records for the authenticated user
    $checkOutRecords = AbsensiCheckOut::where('user_id', $userId)->get();

    // Retrieve all records for the authenticated user
    $records = Record::where('user_id', $userId)->get();

    return view('attendance.all_data', compact('checkInRecords', 'checkOutRecords', 'records'));
}
}
