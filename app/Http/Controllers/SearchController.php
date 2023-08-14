<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        return view('admin.pages.attendances.exports');
    }

    public function searchUser(Request $request)
    {
        $query = $request->get('query');
        $filterResult = User::where('nama', 'LIKE', '%' . $query . '%')->get();
        return response()->json($filterResult);
    }
}
