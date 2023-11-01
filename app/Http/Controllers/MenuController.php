<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class MenuController extends Controller
{
    public function getData($tahun)
    {
        $client = new Client;

        $response = $client->get("http://tes-web.landa.id/intermediate/transaksi?tahun=".$tahun);

        $data = json_decode($response->getBody(), true);

        return $data;
    }

    public function getMenu()
    {
        $client = new Client();

        $response = $client->get("http://tes-web.landa.id/intermediate/menu");

        $data = json_decode($response->getBody(), true);

        return $data;
    }

    public function menu(Request $request)
    {
        if($request->input('tahun') != null){
            $penjualan = $this->getData($request->input('tahun'));
            $menu = $this->getMenu();
            
            return view('test', [
                'penjualan' => $penjualan,
                'menu' => $menu,
                'tahun' => $request->input('tahun')
            ]);
        }else{
            return view('test', [
                'tahun' => ''
            ]);
        }
    }

    public function index()
    {
        return view('test', [
            'tahun' => ''
        ]);
    }
}
