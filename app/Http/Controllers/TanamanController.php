<?php

namespace App\Http\Controllers;

use App\Models\Tanaman;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
}
