<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use JWTAuth;
use App\User;
use App\Transaksi;

class SaldoController extends Controller
{
    public function saldo()
    {
    	$data = User::all();
        return response($data);
    }
    public function saldoAuth()
    {
    	$data = "Selamat datang " . Auth::user()->username;
    	return response()->json($data, 200);
    }
    public function update(Request $request, $id)
    {
        try {
            $data = User::where('id', $id)->first();
            $data->username = $request->input('username');
            $data->password = $request->input('password');
            $data->jml_saldo = $data->jml_saldo + $request->input('jml_saldo');
            $data->save();

            return response()->json([
                $data = User::all(),
                "message" => "Update Saldo berhasil"
            ]);
        } catch (\Exception $e){
            return response()->json([
                "message" => "Update Saldo gagal"
            ]);
        }
    }
    public function proses(Request $request)
    {
        $trans = new Transaksi();
        $user = JWTAuth::parseToken()->authenticate();

        $trans->username = $user->username;
        $trans->nama_transaksi = $request->input('nama_transaksi');
        $trans->jenis = $request->input('jenis');
        $trans->jumlah = $request->input('jumlah');

        if ($request->jenis == "kredit"){
            $saldo_akhir = $user->jml_saldo - $request->jumlah;
        } else if ($request->jenis == "debit"){
            $saldo_akhir = $user->jml_saldo + $request->jumlah;
        } else {
            return "Salah";
        }
        $trans->save();

        $user->jml_saldo = $saldo_akhir;
        $user->save();

        return response()->json(compact('user','trans'));
        
    }
    
}
