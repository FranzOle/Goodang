<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;

class StaffSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supplier = Supplier::orderby('created_at', 'DESC')->get();
        return response()->json([
            'success' => true,
            'data' => $supplier,
        ], 200);
    }

    /**
     * Redirect access denied for creating new resource.
     */
    public function create()
    {
        return response()->json([
            'error' => 'Access denied.',
        ], 403);
    }

    /**
     * Redirect access denied for storing new resource.
     */
    public function store(Request $request)
    {
        return response()->json([
            'error' => 'Access denied.',
        ], 403);
    }

    /**
     * Redirect access denied for displaying the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            'error' => 'Access denied.',
        ], 403);
    }

    /**
     * Redirect access denied for editing resource.
     */
    public function edit(string $id)
    {
        return response()->json([
            'error' => 'Access denied.',
        ], 403);
    }

    /**
     * Redirect access denied for updating resource.
     */
    public function update(Request $request, string $id)
    {
        return response()->json([
            'error' => 'Access denied.',
        ], 403);
    }

    /**
     * Redirect access denied for deleting resource.
     */
    public function destroy(string $id)
    {
        return response()->json([
            'error' => 'Access denied.',
        ], 403);
    }
}
