<?php

namespace App\Http\Controllers;

use App\Models\AbsensiCheckIn;
use App\Models\AbsensiCheckOut;
use App\Models\Record;
use App\Models\User;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function removeAll(Request $request)
    {
        try {
            $ids = $request->input('id');

            if (!empty($ids)) {
                User::whereIn('id', $ids)->delete();
                return response()->json(['message' => 'User records deleted successfully']);
            } else {
                return response()->json(['message' => 'No users selected for deletion'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while deleting user records'], 500);
        }
    }

    public function removeAllCheckins(Request $request)
    {
        try {
            $ids = $request->input('id');

            if (!empty($ids)) {
                foreach ($ids as $checkinId) {
                    $this->deleteCheckinWithAssociatedData($checkinId);
                }

                return response()->json(['message' => 'Check-in records deleted successfully']);
            } else {
                return response()->json(['message' => 'No check-in records selected for deletion'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while deleting check-in records'], 500);
        }
    }

    public function removeAllCheckouts(Request $request)
    {
        try {
            $ids = $request->input('id');

            if (!empty($ids)) {
                foreach ($ids as $checkoutId) {
                    $this->deleteCheckoutWithAssociatedData($checkoutId);
                }

                return response()->json(['message' => 'Check-out records deleted successfully']);
            } else {
                return response()->json(['message' => 'No check-out records selected for deletion'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while deleting check-out records'], 500);
        }
    }

    public function removeAllRecords(Request $request)
    {
        try {
            $ids = $request->input('id');

            if (!empty($ids)) {
                foreach ($ids as $recordId) {
                    $this->deleteRecordWithAssociatedData($recordId);
                }

                return response()->json(['message' => 'Records deleted successfully']);
            } else {
                return response()->json(['message' => 'No records selected for deletion'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while deleting records'], 500);
        }
    }

    private function deleteCheckinWithAssociatedData($checkinId)
    {
        $checkin = AbsensiCheckIn::find($checkinId);

        if ($checkin) {
            $associatedRecords = Record::where('absensi_check_in_id', $checkinId)->get();
            foreach ($associatedRecords as $record) {
                $this->deleteRecordWithAssociatedData($record->id);
            }
            $checkin->delete();
        }
    }

    private function deleteCheckoutWithAssociatedData($checkoutId)
    {
        $checkout = AbsensiCheckOut::find($checkoutId);

        if ($checkout) {
            $associatedRecords = Record::where('absensi_check_out_id', $checkoutId)->get();
            foreach ($associatedRecords as $record) {
                $this->deleteRecordWithAssociatedData($record->id);
            }
            $checkout->delete();
        }
    }

    private function deleteRecordWithAssociatedData($recordId)
    {
        $record = Record::find($recordId);

        if ($record) {
            $record->delete();
            $checkinId = $record->absensi_check_in_id;
            $checkoutId = $record->absensi_check_out_id;

            if ($checkinId) {
                $this->deleteCheckinWithAssociatedData($checkinId);
            }
            if ($checkoutId) {
                $this->deleteCheckoutWithAssociatedData($checkoutId);
            }
        }
    }
}
