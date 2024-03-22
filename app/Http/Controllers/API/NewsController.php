<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseFormatSame;

class NewsController extends Controller
{
    public function index(){
        try {
            $news = News::latest()->get();
            return ResponseFormatter::success([
                $news,
                'Data List Of News'
            ]);
        } catch (\Exception $error) {
            return ResponseFormatter::error([
                'massage' => 'Someting went Wrong',
                'error' => $error
            ], 'Auththentication Failed', 500);
        }
    }

    // Get data by id
    public function show($id){
        try {
            //Get data by id
            $news = News::findOrFail($id);
            return ResponseFormatter::success([
                $news,
                'Data List Of id'
            ]);


        } catch (\Exception $error) {
            return ResponseFormatter::error([
                'massage' => 'Someting went Wrong',
                'error' => $error
            ], 'Auththentication Failed', 500);
        }
    }

}

