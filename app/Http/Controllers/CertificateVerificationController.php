<?php

namespace App\Http\Controllers;

use App\Models\Certificate;

class CertificateVerificationController extends Controller
{
    /**
     * Halaman publik verifikasi keaslian sertifikat.
     */
    public function show($id)
    {
        $certificate = Certificate::with(['student.user', 'verifier'])->findOrFail($id);

        $isVerified = $certificate->status === 'verified';

        return view('verify.certificate', compact('certificate', 'isVerified'));
    }

    /**
     * Cek sertifikat berdasarkan nomor sertifikat (form pencarian).
     */
    public function lookup()
    {
        $number = request('number');

        if (!$number) {
            return redirect()->route('verify.index')->with('error', 'Masukkan nomor sertifikat.');
        }

        $certificate = Certificate::with(['student.user', 'verifier'])
            ->where('certificate_number', $number)
            ->first();

        if (!$certificate) {
            return redirect()->route('verify.index')->with('error', 'Sertifikat dengan nomor tersebut tidak ditemukan.');
        }

        return redirect()->route('verify.certificate', $certificate->id);
    }
}
