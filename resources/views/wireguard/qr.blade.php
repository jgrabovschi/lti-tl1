@extends('layout.main')

@section('main')

<div class="flex justify-center">
    <div class="block p-6 w-md bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">WireGuard Peer</h5>
        <p class="font-normal text-gray-700 dark:text-gray-400">Read the following QR code to configure a client automatically.</p>
    </div>
</div>

<form method="GET" action="{{ route('showWireguardPeers') }}">
    <button type="submit" class="mt-4 text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-4">
        Back
    </button>
</form>

<div class="w-min p-6 bg-white border border-gray-200 rounded-lg shadow-s">
    {!! $qr !!}
</div>

@endsection
