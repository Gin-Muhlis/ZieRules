<?php

namespace App\Http\Controllers\Api;

require_once app_path() . '/Helpers/helpers.php';

use App\Http\Controllers\Controller;
use App\Models\Quote;
use Exception;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function generateQuote()
    {
        try {
            $this->authorize('student-view-any', Quote::class);

            $id_quotes = Quote::pluck('id');

            $randIndex = rand(0, count($id_quotes) - 1);

            $quote = Quote::with('teacher')->findOrFail($id_quotes[$randIndex]);

            return response()->json([
                'status' => 200,
                'teacher' => $quote->teacher->name,
                'image_teacher' => $quote->teacher->image,
                'date' => generateDate($quote->date->toDateString()),
                'quote' => $quote->quote
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
