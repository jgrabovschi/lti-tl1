<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class DhcpController extends Controller
{
    public function indexPool(): View
    {
        $client = new Client([
            'verify' => false
        ]);
        $res = $client->get('https://' . session('address') . '/rest/ip/pool', ['auth' =>  [session('username'), session('password')]]);

        return view('dhcp.indexPool')->with('data', json_decode($res->getBody()));
    }

    public function downloadDhcpPool()
    {
        $client = new Client([
            'verify' => false
        ]);
        $res = $client->get('https://' . session('address') . '/rest/ip/pool', ['auth' =>  [session('username'), session('password')]]);

        $tempFilePath = storage_path('app/temp.json');
        file_put_contents($tempFilePath, $res->getBody());

        // Return the file as a downloadable response
        return response()->download($tempFilePath, 'DhcpPoll.json')->deleteFileAfterSend(true);

    }

    public function createDhcpPool()
    {
        return view('dhcp.createPool');

    }

    public function editDhcpPool(string $id)
    {
        $client = new Client([
            'verify' => false
        ]);

        $res = $client->get('https://' . session('address') . '/rest/ip/pool/' . $id, ['auth' =>  [session('username'), session('password')]]);

        $res = json_decode($res->getBody());

        $ranges = $res->{'ranges'};
        $ranges = explode('-', $ranges);

        return view('dhcp.editPool')->with('dhcpPool', $res)->with('rangeBegin', $ranges[0])->with('rangeEnd', $ranges[1]);
    }

    public function storeDhcpPool(Request $request)
    {

        $request->validate([
            'name' => ['required','string'],
            'rangeBegin' => ['required','ip'],
            'rangeEnd' => ['required','ip'],
        ]);

        $name = $request->input('name');
        $ranges = $request->input('rangeBegin') . '-' . $request->input("rangeEnd");

        $client = new Client([
            'verify' => false
        ]);

        $res = $client->put('https://' . session('address') . '/rest/ip/pool', ['auth' =>  [session('username'), session('password')],
                            'json' => ['name' => $name, 'ranges' => $ranges ]]);

        return redirect()->route('showDhcpPool')->with('success', 'DHCP updated successfully!');

    }

    public function updateDhcpPool(Request $request, string $id)
    {

        $request->validate([
            'name' => ['required','string'],
            'rangeBegin' => ['required','ip'],
            'rangeEnd' => ['required','ip'],
        ]);

        $name = $request->input('name');
        $ranges = $request->input('rangeBegin') . '-' . $request->input("rangeEnd");

        $client = new Client([
            'verify' => false
        ]);

        $res = $client->put('https://' . session('address') . '/rest/ip/pool/' .$id, ['auth' =>  [session('username'), session('password')],
                            'json' => ['name' => $name, 'ranges' => $ranges ]]);

        return redirect()->route('showDhcpPool')->with('success', 'DHCP updated successfully!');

    }

    public function destroyDhcpPool(string $id)
    {
        $client = new Client([
            'verify' => false
        ]);
        $res = $client->delete('https://' . session('address') . '/rest/ip/pool/' .$id, ['auth' =>  [session('username'), session('password')]]);

        return redirect()->route('showDnsStatic')->with('success', 'Data deleted successfully!');
    }
}
