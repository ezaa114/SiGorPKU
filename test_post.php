<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\PemilikGor;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

// 1. Log in the owner Hendra Wijaya (id = 2)
$owner = PemilikGor::where('email', 'angkasa@demo.com')->first();
Auth::guard('pemilik')->login($owner);
echo "Logged in as: " . Auth::guard('pemilik')->user()->nama . " (ID: " . Auth::guard('pemilik')->user()->id_pemilik . ")\n";

// 2. Mock a request to the konfirmasi route
$request = Request::create('/pemilik/pembayaran/2/konfirmasi', 'POST', [
    'status' => 'dikonfirmasi'
]);

// Run the route handler directly or run controller method directly
$controller = new App\Http\Controllers\PemilikGor\PembayaranController();

try {
    $response = $controller->konfirmasi($request, 2);
    echo "Response status: " . $response->getStatusCode() . "\n";
    if (method_exists($response, 'getSession')) {
        echo "Session errors: " . print_r($response->getSession()->get('errors'), true) . "\n";
    }
    echo "Session success msg: " . session('success') . "\n";
    echo "Session error msg: " . session('error') . "\n";
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
    echo "Stack trace: \n" . $e->getTraceAsString() . "\n";
}
