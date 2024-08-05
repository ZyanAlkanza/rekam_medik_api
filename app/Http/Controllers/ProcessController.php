<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Visit;
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
        $data = Patient::with('visit')->get();
        
        return response()->json([
            "status"    => "success",
            "code"      => 200,
            "message"   => "Data Loaded Successfully",
            "data"      => $data
        ], 200);
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

        return response()->json([
            "status"    => "success",
            "code"      => 200,
            "message"   => "Data Created Successfully",
            "data"      => $data
        ], 200);
    }

    public function make_visit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_rekam_medik'  => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                "status"    => "error",
                "code"      => 400,
                "message"   => "Validation Error",
                "error"     => $validator->errors()
            ], 400);
        }

        $exist = Patient::where('no_rekam_medik', $request->no_rekam_medik)->first();

        if(!$exist){
            return response()->json([
                "status"    => "error",
                "code"      => 404,
                "message"   => "Data Doesn't Exists"
            ], 404);
        }

        $ever_visited = Visit::where('no_rekam_medik', $request->no_rekam_medik)->first();

        if ($ever_visited) {
            $ever_visited->jumlah_kunjungan += 1;
            $ever_visited->save();

            return response()->json([
                "status"    => "success",
                "code"      => 200,
                "message"   => "Data Created Successfully",
            ], 200);

        } else {
            Visit::create([
                'no_rekam_medik'   => $request->no_rekam_medik,
                'jumlah_kunjungan' => 1
            ]);

            return response()->json([
                "status"    => "success",
                "code"      => 200,
                "message"   => "Data Created Successfully",
            ], 200);
        }

    }
}
