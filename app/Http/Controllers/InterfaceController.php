<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class InterfaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $client = new Client();
        $res = $client->get('http://' . session('address') . '/rest/interface', ['auth' =>  [session('username'), session('password')]]);

        return view('interfaces.interfaces')->with('data', $res->getBody());
    }


    public function wireless()
    {
        $client = new Client();
        $res = $client->get('http://' . session('address') . '/rest/interface/wireless', ['auth' =>  [session('username'), session('password')]]);

        return view('interfaces.wireless')->with('data', $res->getBody());
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function download()
    {
        $client = new Client();
        $res = $client->get('http://' . session('address') . '/rest/interface', ['auth' =>  [session('username'), session('password')]]);

        $tempFilePath = storage_path('app/temp.json');
        file_put_contents($tempFilePath, $res->getBody());

        // Return the file as a downloadable response
        return response()->download($tempFilePath, 'interfaces.json')->deleteFileAfterSend(true);

    }

    public function downloadWireless()
    {
        $client = new Client();
        $res = $client->get('http://' . session('address') . '/rest/interface/wireless', ['auth' =>  [session('username'), session('password')]]);

        $tempFilePath = storage_path('app/temp.json');
        file_put_contents($tempFilePath, $res->getBody());

        // Return the file as a downloadable response
        return response()->download($tempFilePath, 'wireless.json')->deleteFileAfterSend(true);

    }
}
