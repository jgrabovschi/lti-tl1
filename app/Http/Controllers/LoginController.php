<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;


class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $profiles = Profile::all();
        return view('login.login')->with('profiles', $profiles);
    }

    public function login(Request $request)
    {
        $request->validate([
            'address' => 'required|ip',
            'username' => 'required|string',
            'password' => 'nullable|string'
        ]);

        $address = $request->input('address');
        $username = $request->input('username');
        $password = $request->input('password');

        $client = new Client();
        try
        {
            $client->get('http://'. $address .'/rest', [
                'auth' =>  [$username, $password ?? ''],
                'connect_timeout' => 15, //in seconds
                'http_errors' => true,
            ]);
        }
        catch (RequestException $e) {
            // if it respods with unauthorized that means that the auth params are incorect
            // else the login is corect
            if ($e->getCode() == 401)
            {
                return back()->withErrors(['global' => 'Invalid credentials'])->withInput();
            }
            else if ($e->getCode() == 400) {
                session([
                    'address' => $request->input('address'),
                    'username' => $request->input('username'),
                    'password' => $request->input('password'),
                ]);

                if (!Profile::where('username', $request->input('username'))
                    ->where('address', $request->input('address'))
                    ->exists())
                {
                    Profile::create([
                        'username' => $request->input('username'),
                        'address' => $request->input('address'),
                    ]);
                }
    
                return redirect()->route('showInterfaces');
            }
        }
        catch (Exception $e)
        {
            return back()->withErrors(['global' => 'Something went wrong... Check the if the router is on or if the REST API is working.'])->withInput();
        }

        
        return back()->withErrors(['global' => 'Something went wrong...'])->withInput();
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}
