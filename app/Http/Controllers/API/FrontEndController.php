<?php

namespace App\Http\Controllers\Api;

use App\Models\News;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class FrontEndController extends Controller
{
    public function index(){
        // Get Carousel News Latest
        $news = News::latest()->limit(3)->get();
        return ResponseFormatter::success([
            $news,
            'Data Carousel'
        ]);
        try {
            
        } catch (\Exception $error) {
            return ResponseFormatter::error([
                'massage' => 'Someting went Wrong',
                'error' => $error
            ], 'Auththentication Failed', 500);
        }
    }
}
