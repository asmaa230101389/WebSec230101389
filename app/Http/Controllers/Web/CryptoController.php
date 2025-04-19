<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CryptoController extends Controller
{
    public function showForm()
    {
        return view('crypto');
    }

    public function encrypt(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
        ]);

        $encrypted = Crypt::encryptString($request->text);

        return view('crypto', [
            'result' => $encrypted,
            'operation' => 'encrypt'
        ]);
    }

    public function decrypt(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
        ]);

        try {
            $decrypted = Crypt::decryptString($request->text);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return view('crypto', [
                'error' => 'Invalid encrypted text or wrong key.',
                'operation' => 'decrypt'
            ]);
        }

        return view('crypto', [
            'result' => $decrypted,
            'operation' => 'decrypt'
        ]);
    }
}