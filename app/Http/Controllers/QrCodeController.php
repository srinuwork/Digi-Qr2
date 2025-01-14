<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    // Generate QR Code
    public function generateQrCode(Request $request)
    {
        // Validate the 'type' input
        $request->validate([
            'type' => 'required',
        ]);

        $qrData = '';

        // Handle QR code data generation based on the selected type
        switch ($request->type) {
            case 'url':
                $request->validate(['url' => 'required|url']);
                $qrData = $request->url;
                break;

            case 'text':
                $request->validate(['text' => 'required']);
                $qrData = $request->text;
                break;

            case 'email':
                $request->validate(['email' => 'required|email']);
                $qrData = "mailto:" . $request->email;
                break;

            case 'wifi':
                $request->validate([
                    'ssid' => 'required',
                    'password' => 'nullable',
                ]);
                $qrData = "WIFI:T:WPA;S:" . $request->ssid . ";P:" . $request->password . ";H:" . ($request->hidden ? 'true' : 'false') . ";";
                break;

            case 'phone':
                $request->validate(['phone' => 'required|regex:/^[+]*[0-9]{1,15}$/']);
                $qrData = "tel:" . $request->phone;
                break;

            default:
                return back()->with('error', 'Invalid QR code type selected.');
        }

        // Generate the QR Code as a PNG image
        $qrCode = QrCode::format('svg') // Set the output format to PNG
            ->size(300) // Set the size of the QR code
            ->generate($qrData); // Generate the QR code with the specified data
            
        // Return the view with the generated QR code as a Base64 string
        return back()->with('qrCode', $qrCode);
    }
}

