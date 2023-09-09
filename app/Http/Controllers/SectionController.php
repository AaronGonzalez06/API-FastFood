<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Section;

class SectionController extends Controller
{
    public function list(){
        $sections = Section::with('products')->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'totalSection' => $sections->count(),
            'sections' => $sections
        ]);
    }
}
