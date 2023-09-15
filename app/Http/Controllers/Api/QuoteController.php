<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function __construct() {
        $this->middleware('auth:sanctum');
    }

    public function generateQuote() {
        $id_quotes = Quote::pluc('id');
        dd($id_quotes);
    }

}
