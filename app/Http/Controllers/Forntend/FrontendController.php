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

    public function detailNews($slug){
        // Get data category
        $category = Category::latest()->get();

        // Get Data News
        $news = News::where('slug', $slug)->first();

        // Get data side News
        $sideNews = News::latest()->limit(3)->get();

        return view('frontend.news.detail', compact(
            'category',
            'news', 
            'sideNews'
        ));
    }

    public function detailCategory($slug){
        // get data category
        $category = Category::latest()->get();

        // Get data category by slug
        $detailCategory = Category::where('slug', $slug)->first();

        // get data news by category
        $news = News    ::where('category_id', $detailCategory->id)->latest()->get();

        // Get data side bar
        $sideNews = News::latest()->limit(3)->get();

        return view('frontend.news.detail-category', compact(
            'category',
            'detailCategory',
            'news',
            'sideNews'
        ));
    }
}

