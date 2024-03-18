<?php

namespace App\Http\Controllers\Forntend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    //
    public function index(){
        $title = 'Home';

        // Get data category
        $category =  Category::latest()->get();

        // Get slider news category
        $sliderNews = News::latest()->limit(3)->get();

        return view('frontend.news.index', compact(
            'title',
            'category',
            'sliderNews'
        ));
    }
}
