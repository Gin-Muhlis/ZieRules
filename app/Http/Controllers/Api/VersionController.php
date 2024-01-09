<?php

namespace App\Http\Controllers\Api;

require_once app_path() . '/helpers/helpers.php';

use App\Http\Controllers\Controller;
use App\Models\Version;
use Exception;
use Illuminate\Http\Request;

class VersionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $version = Version::latest()->first();

            return response()->json([
                'status' => 200,
                'data' => [
                    'version' => $version->version,
                    'release_time' => generateFromDatetime($version->release_time)
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
