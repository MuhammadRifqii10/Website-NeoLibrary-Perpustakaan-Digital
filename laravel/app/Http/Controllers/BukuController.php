<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BukuController extends Controller
{
    // Tampilkan semua buku (READ)
  public function index()
    {
        $data = Buku::all();
        return view('buku.index', compact('data'));
    }

    // Form tambah buku (CREATE)
    public function create()
    {
        return view('buku.create');
    }

    // Proses tambah buku
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|integer',
            'stok' => 'required|integer',
        ]);

        Buku::create($request->all());

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    // Form edit buku
   public function edit($id_buku)
{
    $buku = Buku::findOrFail($id_buku);
    return view('buku.edit', compact('buku'));
}

    // Proses update buku
    public function update(Request $request, $id_buku)
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|integer',
            'stok' => 'required|integer',
        ]);

        Buku::findOrFail($id_buku)->update($request->all());

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui!');
    }

    // Hapus buku
    public function destroy($id_buku)
    {
        Buku::findOrFail($id_buku)->delete();
        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus!');
    }

    public function cetakPDF()
{
    $data = Buku::all();

    $pdf = Pdf::loadView('buku.laporan_pdf', compact('data'))
              ->setPaper('a4', 'portrait');

    return $pdf->stream('laporan_buku.pdf');
}
}
