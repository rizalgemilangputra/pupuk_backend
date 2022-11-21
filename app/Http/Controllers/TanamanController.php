<?php

namespace App\Http\Controllers;

use App\Models\Clarifai;
use App\Models\Tanaman;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class TanamanController extends Controller
{
    protected $user;

    public function __construct(Request $request)
    {
        $this->user = User::where('token', $request->header('X-Auth-Token'))->first();
    }

    public function listTanaman(Request $request)
    {
        $plants = Tanaman::where('id_user', $this->user->id)
                    ->join('pupuk', 'pupuk.id', '=', 'tanaman.id_pupuk')
                    ->select('tanaman.id', 'tanaman.umur', 'pupuk.nama', 'pupuk.keterangan', 'tanaman.updated_at', 'tanaman.gambar')
                    ->get();

        $data = [];
        foreach ($plants as $plant) {
            $data[]=[
                'id'            => $plant->id,
                'umur'          => $plant->umur,
                'nama_pupuk'    => $plant->nama,
                'keterangan'    => $plant->keterangan,
                'updated_at'    => Carbon::parse($plant->updated_at)->format('d-m-Y'),
                'gambar'        => $plant->gambar,
            ];
        }

        return response()->json($data);
    }

    public function saveTanaman(Request $request)
    {
        $umur  = 12;
        $image = $request->gambar;
        $folderPath = "images/";

        $image_parts = explode(";base64,", $image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1], true);
        $file = $folderPath . uniqid() . '.'.$image_type;
        Storage::put($file, $image_base64);

        $model = Tanaman::create([
            'id_user'   => $this->user->id,
            'umur'      => $umur,
            'id_pupuk'  => 1,
            'gambar'    => $file
        ]);

        Log::info(storage_path('app/'.$file));

        $res = Clarifai::getData(storage_path('app/'.$file));
        $clarifai = [];
        $time = date('Y-m-d h:m:s');
        foreach ($res as $color) {
            $clarifai[]=[
                'id_tanaman' => $model->id,
                'hex'        => $color->getW3c()->getHex(),
                'warna'      => $color->getW3c()->getName(),
                'nilai'      => $color->getValue(),
                'updated_at' => $time,
                'created_at' => $time
            ];
        }
        Clarifai::insert($clarifai);

        $response = [
            'code'    => 200,
            'message' => 'success add tanaman'
        ];
        return response()->json($response);
    }
}
