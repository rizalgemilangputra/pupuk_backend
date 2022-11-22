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
        $umur  = $request->umur;
        $image = $request->gambar;
        $folderPath = "images/";

        $image_base64 = base64_decode($image, true);
        $file = $folderPath . uniqid() . '.jpeg';
        Storage::put($file, $image_base64);

        $model = Tanaman::create([
            'id_user'   => $this->user->id,
            'umur'      => $umur,
            'id_pupuk'  => 1,
            'gambar'    => $file
        ]);

        Log::info(storage_path('app/'.$file));

        $res = Clarifai::getData('https://sawitindonesia.com/wp-content/uploads/2020/07/Culvularia-pdf-5-scaled.jpg');
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
            'code'    => 201,
            'message' => 'success add tanaman'
        ];
        return response()->json($response);
    }

    public function deleteTanaman(Request $request)
    {
        $id = $request->id;

        Tanaman::where('id', $id)->where('id_user', $this->user->id)->delete();

        $response = [
            'code'    => 201,
            'message' => 'success delete plant'
        ];

        return response()->json($response);
    }
}
