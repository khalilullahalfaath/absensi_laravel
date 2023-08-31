<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AbsensiCheckIn;
use App\Models\AbsensiCheckOut;
use App\Models\Record;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class AttendanceController extends Controller
{
    function attendance()
    {
        // Menampilkan form register
        return view('attendance.index');
    }

    function computeDistance($lat1, $lng1, $lat2, $lng2, $radius = 6378137)
    {
        static $x = M_PI / 180;
        $lat1 *= $x;
        $lng1 *= $x;
        $lat2 *= $x;
        $lng2 *= $x;
        $distance = 2 * asin(sqrt(pow(sin(($lat1 - $lat2) / 2), 2) + cos($lat1) * cos($lat2) * pow(sin(($lng1 - $lng2) / 2), 2)));

        // dd($distance);

        return $distance * $radius;
    }


    public function create(Request $request)
    {
        // Validate the location input
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');



        // dd($latitude, $longitude);

        // validate latitude and longitude
        if (!$latitude || !$longitude) {
            return redirect('sessions/home')->withErrors('Invalid location.');
        }

        // define the target latitude and longitude
        $targetLatitude = -6.949960;
        $targetLongitude = 107.619321;

        // calculate the distance between the target location and the input location
        $distance = $this->computeDistance($latitude, $longitude, $targetLatitude, $targetLongitude);


        // dd($distance);


        // if the distance is more than 1 km, redirect back with an error message
        if ($distance > 100) {
            return redirect('sessions/home')->withErrors('You are not within the office area.');
        }

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
                return redirect('sessions/home')->withErrors($result['message']);
            }
        } else {
            // If an invalid attendance type is provided, redirect back with an error message
            return redirect('sessions/home')->withErrors('You are not within the office area.');
        }

        // dd($result);

        if ($result['success']) {
            // if success
            return redirect('sessions/home')->with('success', 'absensi berhasil');
        } else {
            return redirect('sessions/home')->withErrors($result['message']);
        }
    }


    public function checkIn(Request $request)
    {
        // Get the current date and time
        $currentDateTime = now();

        // Parse the input date and time from the current date and time
        $inputDate = $currentDateTime->format('Y-m-d');
        $inputTime = $currentDateTime->format('H:i');

        // Combine the input date and time and create a DateTime object
        $inputDateTime = \DateTime::createFromFormat('Y-m-d H:i', "{$inputDate} {$inputTime}");

        // dd($inputDateTime);

        // Check if the input date and time are valid
        if (!$inputDateTime || $inputDateTime->format('Y-m-d H:i') !== "{$inputDate} {$inputTime}") {
            return ['success' => false, 'message' => 'Invalid date or time format.'];
        }

        // Check if the input date and time are after the current date and time
        if ($inputDateTime > $currentDateTime) {
            return ['success' => false, 'message' => 'Cannot check in for future dates.'];
        }

        //  TODO: Check if the input date is a weekend
        // TODO: Check if the clock is not within the check-in time range
        // TODO: Check if the user has already checked in for the given date

        // TODO: check if the time right now is in the future


        // Set the date portion of the $sevenAM DateTime object to be the same as the input date
        $sevenAM = \DateTime::createFromFormat('Y-m-d H:i', "{$inputDate} 07:00");

        // Set the date portion of the $eightAM DateTime object to be the same as the input date
        $eightAM = \DateTime::createFromFormat('Y-m-d H:i', "{$inputDate} 08:00");

        // Check if the input time is before 7 AM
        if ($currentDateTime < $sevenAM) {
            return ['success' => false, 'message' => 'You can only check in after 7 AM.'];
        }

        // Set the date portion of the $nineAM DateTime object to be the same as the input date
        $nineAM = \DateTime::createFromFormat('Y-m-d H:i', "{$inputDate} 09:00");

        // Check if the input time is before 9 AM
        if ($currentDateTime > $nineAM) {
            return ['success' => false, 'message' => 'You can only check in before 9 AM.'];
        }

        // if check-in time is between 7 AM and 8 AM, set the check-in time status to 'ontime'
        if ($currentDateTime >= $sevenAM && $currentDateTime <= $eightAM) {
            $status = 'ontime';
        } else {
            // if check-in time is between 8 AM and 9 AM, set the check-in time status to 'late'
            $status = 'late';
        }

        // find if already checkin
        $checkInRecord = AbsensiCheckIn::where('user_id', Auth::id())
            ->where('tanggal_presensi', $inputDate)
            ->first();

        // if checkin record is exist then return error
        if ($checkInRecord) {
            return ['success' => false, 'message' => 'You have already checked in for today.'];
        }

        // Store check-in data
        $checkInData = [
            'tanggal_presensi' => $currentDateTime->format('Y-m-d'),
            'jam_masuk' => $currentDateTime->format('H:i'),
            'user_id' => Auth::id(),
            'status' => $status,
        ];

        AbsensiCheckIn::create($checkInData);

        return ['success' => true, 'message' => 'Check-in successful'];
    }

    public function checkOut(Request $request)
    {
        // Get the current date and time
        $currentDateTime = now();

        // Parse the input date and time from the current date and time
        $inputDate = $currentDateTime->format('Y-m-d');
        $inputTime = $currentDateTime->format('H:i');

        // Find the corresponding check-in record for the given date and user
        $checkInRecord = AbsensiCheckIn::where('user_id', Auth::id())
            ->where('tanggal_presensi', $inputDate)
            ->first();

        $sixPM = \DateTime::createFromFormat('Y-m-d H:i', "{$inputDate} 18:00");

        if ($currentDateTime > $sixPM) {
            return ['success' => false, 'message' => 'You can only check out before 6 PM.'];
        }

        // find chekout record
        $checkOutRecord = AbsensiCheckOut::where('user_id', Auth::id())
            ->where('tanggal_presensi', $inputDate)
            ->first();

        // if checkout record is exist then return error
        if ($checkOutRecord !== null) {
            return ['success' => false, 'message' => 'You have already checked out for today.'];
        }

        // Check if a check-in record was found
        if ($checkInRecord !== null) {
            // Store check-out data
            $checkOutData = [
                'tanggal_presensi' => $inputDate,
                'jam_keluar' => $inputTime,
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

            // if it's already above 9 AM then the check-in is status is set to 'not check-in' and the check-in is set to 12 AM
            $nineAM = \DateTime::createFromFormat('Y-m-d H:i', "{$inputDate} 09:00");

            $onePM = \DateTime::createFromFormat('Y-m-d H:i', "{$inputDate} 13:00");



            if ($currentDateTime > $nineAM) {
                $checkInData = [
                    'tanggal_presensi' => $currentDateTime->format('Y-m-d'),
                    'jam_masuk' => $onePM->format('H:i'),
                    'user_id' => Auth::id(),
                    'status' => 'not check-in',
                ];

                // check if current date time is not above 1 PM
                if ($currentDateTime < $onePM) {
                    return ['success' => false, 'message' => 'You can only check out after 1 PM.'];
                }

                // create check-in record then get the id
                AbsensiCheckIn::create($checkInData);

                // get the AbsensiCheckIn id
                $checkInRecord = AbsensiCheckIn::where('user_id', Auth::id())
                    ->where('tanggal_presensi', $inputDate)
                    ->first();

                // Store check-out data
                $checkOutData = [
                    'tanggal_presensi' => $inputDate,
                    'jam_keluar' => $inputTime,
                    'user_id' => Auth::id(),
                ];

                $checkOutRecord = AbsensiCheckOut::create($checkOutData);

                $checkintime = $checkInData['jam_masuk'];
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

                return ['success' => true, 'message' => 'Check-out successful'];
            }

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

    public function printCheckInToCSV($id)
    {
        $checkInRecord = AbsensiCheckIn::findOrFail($id);
        $csvContent = "Tanggal Presensi,Jam Masuk, Status\n";
        $csvContent .= "{$checkInRecord->tanggal_presensi},{$checkInRecord->jam_masuk},{$checkInRecord->status}\n";

        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=checkin_record.csv',
        ];

        return response($csvContent, 200, $headers);
    }

    public function printCheckOutToCSV($id)
    {
        $checkOutRecord = AbsensiCheckOut::findOrFail($id);
        $csvContent = "Tanggal Presensi,Jam Keluar\n";
        $csvContent .= "{$checkOutRecord->tanggal_presensi},{$checkOutRecord->jam_keluar}\n";

        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=checkout_record.csv',
        ];

        return response($csvContent, 200, $headers);
    }


    public function printRecordToCSV($id)
    {
        $record = Record::findOrFail($id);
        $csvContent = "Tanggal Presensi,Jam Masuk,Jam Keluar,Jam Kerja, Status Chec-in\n";
        $csvContent .= "{$record->absensiCheckIn->tanggal_presensi},{$record->absensiCheckIn->jam_masuk},{$record->absensiCheckOut->jam_keluar},{$record->jam_kerja},{$record->absensiCheckIn->status}\n";

        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=record.csv',
        ];

        return response($csvContent, 200, $headers);
    }

    public function printAllCheckInToCSV()
    {
        $userId = Auth::id();

        // Retrieve all records for the authenticated user
        $checkInRecords = AbsensiCheckIn::where('user_id', $userId)->get();

        $csvContent = "Tanggal Presensi,Jam Masuk\n";
        foreach ($checkInRecords as $checkInRecord) {
            $csvContent .= "{$checkInRecord->tanggal_presensi},{$checkInRecord->jam_masuk}\n";
        }

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=all_checkin_records.csv',
        ];

        return response($csvContent, 200, $headers);
    }


    public function printAllCheckOutToCSV()
    {
        $userId = Auth::id();

        // Retrieve all records for the authenticated user
        $checkOutRecords = AbsensiCheckOut::where('user_id', $userId)->get();

        $csvContent = "Tanggal Presensi,Jam Keluar\n";
        foreach ($checkOutRecords as $checkOutRecord) {
            $csvContent .= "{$checkOutRecord->tanggal_presensi},{$checkOutRecord->jam_keluar}\n";
        }

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=all_checkout_records.csv',
        ];

        return response($csvContent, 200, $headers);
    }


    public function printAllRecordToCSV()
    {
        $userId = Auth::id();

        // Retrieve all records for the authenticated user
        $records = Record::where('user_id', $userId)->get();

        $csvContent = "Tanggal Presensi,Jam Masuk,Jam Keluar,Jam Kerja\n";
        foreach ($records as $record) {
            $csvContent .= "{$record->absensiCheckIn->tanggal_presensi},{$record->absensiCheckIn->jam_masuk},{$record->absensiCheckOut->jam_keluar},{$record->jam_kerja}\n";
        }

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=all_records.csv',
        ];

        return response($csvContent, 200, $headers);
    }
}
