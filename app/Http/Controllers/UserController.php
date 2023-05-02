<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Dompdf\Dompdf;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function viewHome()
    {
        return view('home');
    }

    public function postHome(Request $request)
    {
        $request->validate([
            "nisn" => "required"
        ], [
            "nisn.required" => "*Nisn tidak boleh kosong!"
        ]);

        $findUser = User::where('nisn', $request->nisn)->first();

        if ($findUser) {
            Auth::login($findUser);
            return redirect()->route('main');
        }
    }

    public function viewMain()
    {
        $user = User::with(['jurusan', 'matpel'])->find(auth()->user()->id);
        // dd($user->matpel->pai);
        $nilai = [
            'mapel' => [
                'Pendidikan Agama dan Budi Pekerti',
                'Pendidikan Kewarganegaraan',
                'Bahasa Indonesia',
                'Matemtika',
                'Sejarah Indonesia',
                'Bahasa Inggris',
                'Seni Budaya',
                'Pendidikan Jasmani Olahraga dan Kebugaran',
                'Bahasa Sunda',
                'Simulasi Digital',
                ($user->jurusan_id == 5) ?'Tinjauan Seni': 'Fisika',
                ($user->jurusan_id == 5) ?'Dasar-Dasar Kreativitas': 'Kimia',
                'Dasar Program Keahlian',
                'Kompetensi Keahlian',
            ],
            'nilai' => [
                $user->matpel->pai,
                $user->matpel->pkn,
                $user->matpel->bindo,
                $user->matpel->mtk,
                $user->matpel->sindo,
                $user->matpel->bing,
                $user->matpel->senbud,
                $user->matpel->pjok,
                $user->matpel->basun,
                $user->matpel->simdig,
                $user->matpel->f_ts,
                $user->matpel->k_ddk,
                $user->matpel->dpk,
                $user->matpel->kk,
            ]
        ]; 
        return view('result', [
            'user' => $user,
            'nilais' => $nilai
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    public function generatePdf()
    {
        $data = User::with(['jurusan'])->find(auth()->user()->id);
        $nilai = auth()->user()->matpel;

        $avg = ($nilai->pai + $nilai->pkn + $nilai->bindo + $nilai->mtk + $nilai->sindo + $nilai->bing + $nilai->senbud + $nilai->pjok + $nilai->basun + $nilai->simdig + $nilai->f_ts + $nilai->k_ddk + $nilai->dpk + $nilai->kk) / 14;
        
        $pdf = Pdf::loadView('dashboard.exportTemplate', ['siswa' => $data, 'nilai' => $nilai, 'avg' => round($avg)]);
        // $pdf->save('Surat Kelulusan.pdf');
        $pdf->setPaper('A4', 'potrait');
        $pdf->render();
        return $pdf->stream('Surat Kelulusan.pdf');
    }
}
