<?php

namespace App\Http\Controllers;

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
}
