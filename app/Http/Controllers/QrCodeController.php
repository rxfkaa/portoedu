<?php

namespace App\Http\Controllers;

use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\SvgWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QrCodeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $portfolioUrl = route('portfolio.show', $user->username ?? $user->name);

        return view('qr-code.index', compact('portfolioUrl', 'user'));
    }

    /** Generate the QR locally so this page does not depend on a third party. */
    public function image(Request $request)
    {
        $user = $request->user();
        $portfolioUrl = route('portfolio.show', $user->username ?? $user->name);
        $qrCode = new QrCode(
            data: $portfolioUrl,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::Medium,
            size: 500,
            margin: 12,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
        );

        $result = (new SvgWriter())->write($qrCode);
        $response = response($result->getString(), 200, [
            'Content-Type' => $result->getMimeType(),
            'Cache-Control' => 'private, max-age=3600',
        ]);

        if ($request->boolean('download')) {
            $response->header('Content-Disposition', 'attachment; filename="qr-portfolio-' . str($user->name ?? 'user')->slug() . '.svg"');
        }

        return $response;
    }
}
