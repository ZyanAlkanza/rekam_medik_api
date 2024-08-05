<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProcessController extends Controller
{
    public function generateNoRekamMedik()
    {
        $lastRecord = Patient::orderBy('created_at', 'desc')->first();
        $lastNoRekamMedik = $lastRecord ? (int) substr($lastRecord->no_rekam_medik, 2) : 0;
        $newNoRekamMedik = 'RM' . str_pad($lastNoRekamMedik + 1, 4, '0', STR_PAD_LEFT);
        return $newNoRekamMedik;
    }

    public function index(){
        'index';
    }

    public function add_patient(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama_pasien'   => ['required','min:3','regex:/^[a-zA-Z\s]+$/'],
            'nik'           => 'required|min:16|numeric',
            'alamat'        => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                "status"    => "error",
                "code"      => 400,
                "message"   => "Validation Error",
                "error"     => $validator->errors()
            ], 400);
        }

        $check_nik = Patient::where('nik', $request->nik)->first();

        if($check_nik){
            return response()->json([
                "status"    => "error",
                "code"      => 409,
                "message"   => "Data Already Exists"
            ], 409);
        }

        $noRekamMedik = $this->generateNoRekamMedik();

        $data = Patient::create([
            'no_rekam_medik' => $noRekamMedik,
            'nama_pasien'    => $request->nama_pasien,
            'nik'            => $request->nik,
            'alamat'         => $request->alamat
        ]);

        // $data = ([
        //     'no_rekam_medik'=> $noRekamMedik,
        //     'nama_pasien'   => $request->nama_pasien,
        //     'nik'           => $request->nik,
        //     'alamat'        => $request->alamat
        // ]);

        return response()->json([
            "status"    => "success",
            "code"      => 200,
            "message"   => "Data Create Successfully",
            "data"      => $data
        ], 200);
    }
}
