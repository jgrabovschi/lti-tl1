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
            $res = $client->get('http://'. $address .'/rest/system/identity', [
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
            
            return back()->withErrors(['global' => 'Something went wrong...'])->withInput();
        }
        catch (Exception $e)
        {
            return back()->withErrors(['global' => 'Something went wrong... Check the if the router is on or if the REST API is working.'])->withInput();
        }

        $identity = json_decode($res->getBody()->getContents())->name;

        // save the login data in the session
        session([
            'address' => $request->input('address'),
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'identity' => $identity
        ]);

        // save the login data in the database
        if (!Profile::where('username', $request->input('username'))
            ->where('address', $request->input('address'))
            ->where('identity', $identity)
            ->exists())
        {
            Profile::create([
                'username' => $request->input('username'),
                'address' => $request->input('address'),
                'identity' => $identity
            ]);
        }
        return redirect()->route('showInterfaces');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }

    public function deleteProfile(Profile $profile)
    {
        $profile->delete();
        return redirect()->back();
    } 
    

}
