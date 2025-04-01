@extends('layout.main')

@section('main')

<div class="flex justify-center">
    <div class="block p-6  w-md bg-white border border-gray-200 rounded-lg shadow-sm  dark:bg-gray-800 dark:border-gray-700">
    
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Configure Wireless Network</h5>
        <p class="font-normal text-gray-700 dark:text-gray-400">Here you can configure the wireless network.</p>
    
    </div>
</div>
<form method="GET" action="{{ route('showInterfacesWireless') }}">
    
    <button type="sumbit" class="mt-4 text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 ">
        Back
    </button>

</form>

<div class="mx-auto w-full md:w-1/2 lg:w-1/3 p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">

    <form method="POST" class="max-w-sm mx-auto">
        @csrf
        @method('PATCH')
        <div class="mb-5">
        <label for="ssid" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">SSID</label>
        <input type="text" name="ssid" id="ssid" value="{{ $wlan->ssid }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" />
        @error('ssid')
            <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
        @enderror
        </div>

        <div class="mb-5">
            <label for="security-profiles" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select a security profile</label>
            <select name="security-profile" id="security-profiles" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                @foreach ($securityProfiles as $securityProfile)
                    <option {{ $securityProfile->name == $wlan->{'security-profile'} ? 'selected' : ''}} value="{{ $securityProfile->name }}">{{ $securityProfile->name }}</option>
                @endforeach              
            </select>
        </div>
        {{-- <div class="mb-5">
        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your password</label>
        <input type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
        </div> --}}
        
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
    </form>
    
</div>



@endsection