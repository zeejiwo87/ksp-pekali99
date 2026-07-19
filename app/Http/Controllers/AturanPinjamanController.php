<?php

namespace App\Http\Controllers;

use App\Models\AturanPinjaman;
use Illuminate\Http\Request;

class AturanPinjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if ($redirect = $this->authorizeRoles(['admin'])) {
            return $redirect;
        }

        $aturanPinjaman = AturanPinjaman::orderBy('penghasilan_min')->get();

        return view('pinjaman.aturan_pinjaman', compact('aturanPinjaman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($redirect = $this->authorizeRoles(['admin'])) {
            return $redirect;
        }

        $request->validate([
            'penghasilan_min'   => 'required|numeric|min:0',
            'penghasilan_max'   => 'required|numeric|gte:penghasilan_min',
            'maksimal_pinjaman' => 'required|numeric|min:1',
        ]);

        // Cek apakah rentang bertabrakan
        $overlap = AturanPinjaman::where(function ($query) use ($request) {
            $query->whereBetween('penghasilan_min', [
                $request->penghasilan_min,
                $request->penghasilan_max
            ])
                ->orWhereBetween('penghasilan_max', [
                    $request->penghasilan_min,
                    $request->penghasilan_max
                ])
                ->orWhere(function ($q) use ($request) {
                    $q->where('penghasilan_min', '<=', $request->penghasilan_min)
                        ->where('penghasilan_max', '>=', $request->penghasilan_max);
                });
        })->exists();

        if ($overlap) {
            return back()
                ->withInput()
                ->with('error', 'Rentang penghasilan bertabrakan dengan aturan yang sudah ada.');
        }

        AturanPinjaman::create([
            'penghasilan_min'   => $request->penghasilan_min,
            'penghasilan_max'   => $request->penghasilan_max,
            'maksimal_pinjaman' => $request->maksimal_pinjaman,
        ]);

        return redirect()
            ->route('aturan-pinjaman.index')
            ->with('success', 'Aturan pinjaman berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if ($redirect = $this->authorizeRoles(['admin'])) {
            return $redirect;
        }

        $request->validate([
            'penghasilan_min'   => 'required|numeric|min:0',
            'penghasilan_max'   => 'required|numeric|gte:penghasilan_min',
            'maksimal_pinjaman' => 'required|numeric|min:1',
        ]);

        // Cek apakah rentang penghasilan bertabrakan
        $overlap = AturanPinjaman::where('id', '!=', $id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('penghasilan_min', [
                    $request->penghasilan_min,
                    $request->penghasilan_max
                ])
                    ->orWhereBetween('penghasilan_max', [
                        $request->penghasilan_min,
                        $request->penghasilan_max
                    ])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('penghasilan_min', '<=', $request->penghasilan_min)
                            ->where('penghasilan_max', '>=', $request->penghasilan_max);
                    });
            })
            ->exists();

        if ($overlap) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Rentang penghasilan bertabrakan dengan aturan yang sudah ada.');
        }

        $aturan = AturanPinjaman::findOrFail($id);

        $aturan->update([
            'penghasilan_min'   => $request->penghasilan_min,
            'penghasilan_max'   => $request->penghasilan_max,
            'maksimal_pinjaman' => $request->maksimal_pinjaman,
        ]);

        return redirect()->route('aturan-pinjaman.index')
            ->with('success', 'Aturan pinjaman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if ($redirect = $this->authorizeRoles(['admin'])) {
            return $redirect;
        }

        $aturan = AturanPinjaman::findOrFail($id);

        $aturan->delete();

        return redirect()->route('aturan-pinjaman.index')
            ->with('success', 'Aturan pinjaman berhasil dihapus.');
    }
}
