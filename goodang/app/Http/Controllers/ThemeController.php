<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThemeController extends Controller
{
    /**
     * Update the sidebar theme preference for the user.
     */
    public function update(Request $request)
    {
        $request->validate([
            'sidebar_theme' => 'required|string|in:sidebar-light-primary,sidebar-dark-primary,sidebar-light-success,sidebar-dark-success',
        ]);

        $user = Auth::user(); 
        $user->sidebar_theme = $request->sidebar_theme;
        $user->save(); 

        return response()->json(['message' => 'Tema sidebar berhasil diperbarui!']);
    }
}
