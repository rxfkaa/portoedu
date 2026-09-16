<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QrCodeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $portfolioUrl = route('portfolio.show', $user->name);

        return view('qr-code.index', compact('portfolioUrl', 'user'));
    }
}
