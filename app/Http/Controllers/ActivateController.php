<?php

namespace App\Http\Controllers;

use App\Models\PesertaMagang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActivateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = PesertaMagang::latest()->get();
        return view('admin.pages.activates.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_presensi' => 'required|unique:peserta_magang,no_presensi',
            'nama_peserta' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_berakhir' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // check if tanggal mulai is greater than tanggal berakhir and it's error for tanggal_mulai field in modal
        if ($request->input('tanggal_mulai') > $request->input('tanggal_berakhir')) {
            return response()->json(['tanggal_mulai' => ['Tanggal mulai must be before tanggal berakhir.']], 422);
        }

        // create new peserta magang
        $pesertaMagang = PesertaMagang::create([
            'no_presensi' => $request->input('no_presensi'),
            'nama_peserta' => $request->input('nama_peserta'),
            'tanggal_mulai' => $request->input('tanggal_mulai'),
            'tanggal_berakhir' => $request->input('tanggal_berakhir'),
            'status_peserta_aktif' => 1,
            'status_akun_aplikasi' => 0,
        ]);

        // return response
        return response()->json([
            'success' => true,
            'message' => 'Peserta magang created successfully',
            'data' => $pesertaMagang,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(PesertaMagang $pesertaMagang)
    {
        // return response
        return response()->json([
            'success' => true,
            'message' => 'Peserta magang retrieved successfully',
            'data' => $pesertaMagang,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request, PesertaMagang $pesertaMagang)
    {
        // define validation rules
        $validator = Validator::make($request->all(), [
            'no_presensi' => 'required|unique:peserta_magang,no_presensi,' . $pesertaMagang->id . ',id',
            'nama_peserta' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_berakhir' => 'required',
            'status_peserta_aktif' => 'required',
            'status_akun_aplikasi' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // check if tanggal mulai is greater than tanggal berakhir and it's error for tanggal_mulai field in modal
        if ($request->input('tanggal_mulai') > $request->input('tanggal_berakhir')) {
            return response()->json(['tanggal_mulai' => ['Tanggal mulai must be before tanggal berakhir.']], 422);
        }

        // update peserta magang
        $pesertaMagang->update([
            'no_presensi' => $request->input('no_presensi'),
            'nama_peserta' => $request->input('nama_peserta'),
            'tanggal_mulai' => $request->input('tanggal_mulai'),
            'tanggal_berakhir' => $request->input('tanggal_berakhir'),
            'status_peserta_aktif' => $request->input('status_peserta_aktif'),
            'status_akun_aplikasi' => $request->input('status_akun_aplikasi'),
        ]);

        // return response
        return response()->json([
            'success' => true,
            'message' => 'Peserta magang updated successfully',
            'data' => $pesertaMagang,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function edit(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // delte peserta magang by id
        PesertaMagang::where('id', $id)->delete();

        // return response
        return response()->json([
            'success' => true,
            'message' => 'Peserta magang deleted successfully',
        ], 200);
    }
}
