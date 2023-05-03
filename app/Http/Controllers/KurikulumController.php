<?php

namespace App\Http\Controllers;

use App\Imports\JurusanImport;
use App\Imports\KelasImport;
use App\Imports\NilaiImport;
use App\Imports\UsersImport;
use App\Models\Jurusan;
use App\Models\Matpel;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class KurikulumController extends Controller
{
    public function viewSigninIn()
    {
        return view('dashboard.signin');
    }
    public function viewJurusan()
    {
        $data = Jurusan::all();
        return view('dashboard/jurusan', [
            'jurusans' => $data
        ]);
    }
    public function editJurusan($id)
    {
        $findData = Jurusan::find($id);
        return view('dashboard/editjurusan', [
            'jurusan' => $findData
        ]);
    }
    public function putJurusan(Request $request, $id)
    {
        $request->validate([
            'jurusan' => 'required'
        ]);

        $findData = Jurusan::find($id);
        $findData->update(['jurusan' => $request->jurusan]);
        return redirect()->route('view.jurusan');
    }
    public function deleteJurusan($id)
    {
        $findData = Jurusan::find($id);
        $findData->delete();
        return redirect()->route('view.jurusan');
    }

    public function viewSiswa()
    {
        $data = User::with(['jurusan'])->where('role', 'user')->orderBy('nama_siswa','asc')->get();
        return view('dashboard/siswa', [
            'siswas' => $data
        ]);
    }
    public function editSiswa($id)
    {
        $findData = User::with(['jurusan'])->find($id);
        $dataJurusan = Jurusan::all();
        return view('dashboard/editsiswa', [
            'siswa' => $findData,
            "dataJurusan" => $dataJurusan
        ]);
    }
    public function putSiswa(Request $request, $id)
    {
        $request->validate([
            'nama_siswa' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'kelas_id' => 'required',
        ]);

        $findData = User::with(['kelas'])->find($id);
        $findData->update($request->all());
        return redirect()->route('view.siswa');
    }
    public function deleteSiswa($id)
    {
        $findData = User::with(['kelas'])->find($id);
        $findData->delete();
        return redirect()->route('view.siswa');
    }

    public function viewInputNilai()
    {
        $data = Matpel::with(['user'])->get();
        return view('dashboard/inputNilai', ['nilais' => $data]);
    }
    public function editInputNilai($id)
    {
        return view('dashboard/editinputNilai');
    }
    public function putInputNilai(Request $request,$id)
    {
        $data = Matpel::find($id);
        $data->update([
            'pai'=> $request->pai,
            'pkn'=> $request->pkn,
            'bindo'=> $request->bindo,
            'mtk'=> $request->mtk,
            'sindo'=> $request->sindo,
            'bing'=> $request->bing,
            'senbud'=> $request->senbud,
            'pjok'=> $request->pjok,
            'basun'=> $request->basun,
            'simdig'=> $request->simdig,
            'f_ts'=> $request->f_ts,
            'k_ddk'=> $request->k_ddk,
            'dpk'=> $request->dpk,
            'kk'=> $request->kk,
        ]);
        return view('dashboard/editinputNilai');
    }

    // import excel
    public function importExcelUser(Request $request)
    {
        dd($$request->time);
        Excel::import(new UsersImport, $request->file('file'));
        return back();
    }

    public function importExcelJurusan(Request $request)
    {
        Excel::import(new JurusanImport, $request->file('file'));
        return back();
    }

    public function importExcelKelas(Request $request)
    {
        Excel::import(new KelasImport, $request->file('file'));
        return back();
    }

    public function importExcelNilai(Request $request)
    {
        Excel::import(new NilaiImport, $request->file('file'));
        return back();
    }

}
