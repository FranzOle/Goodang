<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::orderBy('created_at', 'DESC')->get();
        return view('client.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('client.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|min:2|max:100',
            'alamat' => 'required|min:5|max:255',
            'no_telepon' => 'required|min:10|max:17|unique:clients,no_telepon',
            'email' => 'required|email|max:255|unique:clients,email',
        ]);

        $client = new Client();
        $client->nama = $request->nama;
        $client->alamat = $request->alamat;
        $client->no_telepon = $request->no_telepon;
        $client->email = $request->email;
        $client->save();

        flash('Client baru telah ditambahkan')->success();
        return redirect()->route('client.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Client::findOrFail($id);
        return view('client.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client = Client::findOrFail($id);
        return view('client.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'nama' => 'required|min:2|max:100',
            'alamat' => 'required|min:5|max:255',
            'no_telepon' => 'required|min:10|max:17|unique:clients,no_telepon,' . $id,
            'email' => 'required|email|max:255|unique:clients,email,' . $id,
        ]);

        $client = Client::findOrFail($id);
        $client->nama = $request->nama;
        $client->alamat = $request->alamat;
        $client->no_telepon = $request->no_telepon;
        $client->email = $request->email;
        $client->save();

        flash('Data client telah diperbarui')->success();
        return redirect()->route('client.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        flash('Client telah dihapus')->success();
        return redirect()->route('client.index');
    }

    /**
     * Export clients to PDF.
     */
    public function export()
    {
        $clients = Client::orderBy('created_at', 'DESC')->get();
        $pdf = Pdf::loadView('client.pdf', compact('clients'));
        return $pdf->download('data_clients.pdf');
    }
}
