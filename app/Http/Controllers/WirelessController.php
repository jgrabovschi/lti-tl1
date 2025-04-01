<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class WirelessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function enable(string $id)
    {
        $client = new Client();
        $client->post('http://' . session('address') . '/rest/interface/wireless/enable',
             ['auth' =>  [session('username'), session('password')],
             'json' => ['.id' => $id]],
            );

        return redirect()->route('showInterfacesWireless');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function disable(string $id)
    {
        $client = new Client();
        $client->post('http://' . session('address') . '/rest/interface/wireless/disable', 
        [
            'auth' =>  [session('username'), session('password')],
            'json' => ['.id' => $id],
        ]);

        return redirect()->route('showInterfacesWireless');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function config(string $id)
    {
        $client = new Client();
        $res = $client->get('http://' . session('address') . '/rest/interface/wireless/' . $id, 
        [
            'auth' =>  [session('username'), session('password')],
        ]);
        
        $res2 = $client->get('http://' . session('address') . '/rest/interface/wireless/security-profiles', 
        [
            'auth' =>  [session('username'), session('password')],
        ]);
        
        return view('wireless.config')->with('wlan', json_decode($res->getBody()))
            ->with('securityProfiles', json_decode($res2->getBody()));
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

        $request->validate([
            // 'name' => 'required|string',
            'ssid' => 'required|string',
            'security-profile' => 'required|string',
            // 'password' => 'nullable|string',
            // 'hide_ssid' => 'nullable',
            // 'disabled' => 'nullable',
        ]);
        $client = new Client();
        $client->patch('http://' . session('address') . '/rest/interface/wireless/' . $id, 
        [
            'auth' =>  [session('username'), session('password')],
            'json' => [
                // 'name' => $request->input('name'),
                'ssid' => $request->input('ssid'),
                'security-profile' => $request->input('security-profile'),
                // 'password' => $request->input('password'),
                // 'hide_ssid' => $request->input('hide_ssid'),
                // 'disabled' => $request->input('disabled'),
            ],
        ]);

        return redirect()->route('showInterfacesWireless');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
