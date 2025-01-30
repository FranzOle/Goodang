<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         // Ambil pengaturan pertama
         $settings = Setting::firstOrCreate(Setting::defaultSettings());
         return view('settings.index', compact('settings'));
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
        //
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
        $setting = Setting::findOrFail($id);
        $availableThemes = Setting::availableThemes();
        return view('settings.edit', compact('setting', 'availableThemes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $setting = Setting::findOrFail($id);
        $request->validate([
            'sidebar_theme' => 'required|in:' . implode(',', Setting::availableThemes()),
            'overall_theme' => 'required|in:' . implode(',', Setting::availableThemes()),
            'font' => 'required|string|max:50',
            'terms_and_conditions' => 'nullable|string',
            'terms_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'admin_phone' => 'nullable|string|max:15',
            'company_logo' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
        ]);
        $setting->sidebar_theme = $request->sidebar_theme;
        $setting->overall_theme = $request->overall_theme;
        $setting->font = $request->font;
        $setting->terms_and_conditions = $request->terms_and_conditions;
        $setting->admin_phone = $request->admin_phone;

        if ($request->hasFile('terms_file')) {
            if ($setting->terms_file) {
                Storage::delete($setting->terms_file);
            }
            $setting->terms_file = $request->file('terms_file')->store('uploads/settings');
        }

        if ($request->hasFile('company_logo')) {
            if ($setting->company_logo) {
                Storage::delete($setting->company_logo);
            }
            $setting->company_logo = $request->file('company_logo')->store('uploads/settings');
        }

        $setting->save();

        return redirect()->route('settings.index')->with('success', 'Pengaturan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
