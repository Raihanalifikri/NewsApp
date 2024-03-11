<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'News - Index';
        
        // get data terbaru dari table news/dari model news
        $news = News::latest()->paginate(5);
        $category = Category::all();

        // Return View
        return view('home.news.index', compact(
            'title',
            'news',
            'category'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'News - Create';

        // Model category
        $category = Category::all();

        return view('home.news.create', compact(
            'title',
            'category'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // melakukan validasi
        $this->validate($request,[
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'content' => 'required',
            'category_id' => 'required'
        ]); 

        //aploud image
        // hashName() berfungsi memberikan nama acak pada image

        $image = $request->file('image');
        $image->storeAs('public/news', $image->hashName());

        // Create Data
        News::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'image' => $image->hashName(),
            'content' => $request->content
        ]);


        return redirect()->route('news.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $title = 'News - Show';
         // Get data by id
        // findOrfail jika tidak ada tada maka akan tampil error 404
        $news = News::findOrfail($id);

        return view('home.news.show', compact(
            'title',
            'news'
        ));

       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Get data by id
        $news = News::findOrfail($id);
        $category = Category::all();
        $title = 'News - Edit';

        return view('home.news.edit', compact(
            'title',
            'news',
            'category'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Validate
        $this->validate($request,[
            'title' => 'required|max:255',
            'category_id' => 'required',
            'content' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg|max:5120'
        ]);

        // Get data by id
        $news = News::findOrFail($id);
        
        //cek jika tidak ada image yang di Aploud
        // Check if no image uploaded
        if ($request->file('image') == ""){
              //Update date
              $news->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'category_id' => $request->category_id,
                'content' => $request->content
              ]);
        } else {
            // Hapus Old Image
            Storage::disk('local')->delete('public/news/' . basename($news->image));

            // Apload new Image
            $image = $request->file('image');
            $image->storeAs('public/news', $image->hashName());

            // Update data
            $news->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'category_id' => $request->category_id,
                'image' => $image->hashName(),
                'content' => $request->content,

            ]);
        }

        return redirect()->route('news.index');
    } 
        

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
