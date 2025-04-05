<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class DnsController extends Controller
{
    public function index(): View
    {
        $client = new Client();
        $res = $client->get('http://' . session('address') . '/rest/ip/dns', ['auth' =>  [session('username'), session('password')]]);

        return view('dns.index')->with('data', json_decode($res->getBody()));
    }

    public function downloadDns()
    {
        $client = new Client();
        $res = $client->get('http://' . session('address') . '/rest/ip/dns', ['auth' =>  [session('username'), session('password')]]);

        $tempFilePath = storage_path('app/temp.json');
        file_put_contents($tempFilePath, $res->getBody());

        // Return the file as a downloadable response
        return response()->download($tempFilePath, 'DNS.json')->deleteFileAfterSend(true);

    }

    public function AddServersDns(Request $request)
    {
        $request->validate([
            'numberOfServers' => ['required','numeric','min:1'],
        ]);
        
        $numberOfServers = $request->input('numberOfServers');
        return view('dns.addServers')->with('numberOfServers', $numberOfServers);
    }

    public function AddServersRDns(Request $request)
    {
        $rules = [];

        $servers = "";
        foreach ($request->input() as $key => $value) {
            if (Str::contains($key, 'server')) {
                
                $rules[$key] = 'required|ip'; 
                $servers .= $value . ', ';

            }
            
        }
        $servers = rtrim($servers, ', ');
        $validated = $request->validate($rules);

        $client = new Client();

        $resServers = $client->get('http://' . session('address') . '/rest/ip/dns', ['auth' =>  [session('username'), session('password')]]);

        $resServers = json_decode($resServers->getBody());

        $servers .= ',' . $resServers->{'servers'};

        $res = $client->post('http://' . session('address') . '/rest/ip/dns/set', ['auth' =>  [session('username'), session('password')],
                        'json' => ['servers' => $servers ]]);
        return redirect()->route('showDns')->with('success', 'Dns updated successfully!');
    }

    public function removeServerDns(Request $request)
    {
        $client = new Client();

        $resServers = $client->get('http://' . session('address') . '/rest/ip/dns', ['auth' =>  [session('username'), session('password')]]);

        $resServers = json_decode($resServers->getBody());

        $servers = $resServers->{'servers'};
        $servers = explode(',', $servers);

        return view('dns.removeServers')->with('servers', $servers);
    }

    public function removeServerRDns(Request $request)
    {
        $request->validate([
            'servers' => ['sometimes','array'],
        ]);


        $serverString = "";
        
        if($request->has('servers')){
            $servers = $request->input('servers');
        
            foreach($servers as $server){
                $serverString .= $server .', ';
            }

            $serverString = rtrim($serverString, ', ');
        }
        
        
        $client = new Client();

        $res = $client->post('http://' . session('address') . '/rest/ip/dns/set', ['auth' =>  [session('username'), session('password')],
                        'json' => ['servers' => $serverString ]]);


        return redirect()->route('showDns')->with('success', 'Dns updated successfully!');
    }

    public function storeDns(Request $request)
    {
        
        $request->validate([
            'address' => [
                'required',
                'regex:/^(\d{1,3}\.){3}\d{1,3}(\/\d{1,2})?$/'
            ],
            'network' => [
                'required',
                'ip',
            ],
            'interface' => ['required','string'],
        ]);
        
        $address = $request->input('address');
        $network = $request->input('network');
        $interface = $request->input('interface');

        $client = new Client();
        $res = $client->put('http://' . session('address') . '/rest/ip/dns', ['auth' =>  [session('username'), session('password')],
                            'json' => ['address' => $address, 'network' => $network, 'interface' => $interface ]]);

        //return view('interfaces.bridges')->with('data', $res->getBody());
        return redirect()->route('showAddress')->with('success', 'Data saved successfully!');
    }

    public function toggleDns(Request $request)
    {
        $client = new Client();
        $request->validate([
            'toggle' => [
                'required',
                'string'
            ],
        ]);

        $toggle = $request->input('toggle');
        
        $res = $client->post('http://' . session('address') . '/rest/ip/dns/set', ['auth' =>  [session('username'), session('password')],
                        'json' => ['allow-remote-requests' => $toggle ]]);

        return redirect()->route('showDns')->with('success', 'Data toggled successfully!');
    }

    public function editDns(string $id)
    {
        $client = new Client();
        $res = $client->get('http://' . session('address') . '/rest/ip/address/' . $id, ['auth' =>  [session('username'), session('password')]]);
        $resBridge = $client->get('http://' . session('address') . '/rest/interface/bridge', ['auth' =>  [session('username'), session('password')]]);
        return view('addresses.editAddress')->with('data', json_decode($res->getBody()))->with('id', $id)->with('bridges', json_decode($resBridge->getBody()));
    }

    public function updateDns(Request $request, string $id)
    {
        $request->validate([
            'address' => [
                'required',
                'regex:/^(\d{1,3}\.){3}\d{1,3}(\/\d{1,2})?$/'
            ],
            'network' => [
                'required',
                'ip',
            ],
            'interface' => ['required','string'],
        ]);
        

        $address = $request->input('address');
        $network = $request->input('network');
        $interface = $request->input('interface');
        
        
        $client = new Client();
        $res = $client->patch('http://' . session('address') . '/rest/ip/address/'. $id, ['auth' =>  [session('username'), session('password')],
                        'json' => ['address' => $address, 'network' => $network, 'interface' => $interface  ]]);
        
        return redirect()->route('showAddress')->with('success', 'Data updated successfully!');
        
        /*$client = new Client();
        $res = $client->patch('http://' . session('address') . '/rest/ip/address/'. $id, ['auth' =>  [session('username'), session('password')],
                            'json' => ['address' => $address, 'network' => $network ]]);*/

        //return view('interfaces.bridges')->with('data', $res->getBody());
        //return redirect()->route('showAddress')->with('success', 'Data updated successfully!');
    }
}
