<?php

namespace App\Http\Controllers\Api;

use App\Models\News;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseFormatSame;

class NewsController extends Controller
{
    public function index()
    {
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

    public function store(Request $request){
        try {
            //Validate
            $this->validate($request, [
                'title' => 'required',
                'category_id' => 'required',
                'image' => 'required|image|mimes:png,jpg,jpeg|max:5120',
                'content' => 'required'
            ]);

            //Upload Image
            $image = $request->file('image');
            $image->storeAs('public/news', $image->hashName());

            //Craete Data
            $news = News::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'category_id' => $request->category_id,
                'content' => $request->content,
                'image' => $image->hashName()
            ]);

            return ResponseFormatter::success(
                $news,
                'Data Berhasil di Buat'
            );
        } catch (\Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Authentication', 500);
        }
    }

    public function update(Request $request, $id){
        try {
            //validate
            $this->validate($request, [
                'title' => 'required',
                'category_id' => 'required',
                'image' => 'required|image|mimes:png,jpg,jpeg|max:5120',
                'content' => 'required'
            ]);

            //Get data by id
            $news = News::findOrFail($id);

            // Store Image
            if ($request->file('image') == '') {
                $news->update([
                    'title' => $request->title,
                    'slug' => Str::slug($request->title),
                    'category_id' => $request->category_id,
                    'content' => $request->content
                ]);
            } else {
                // jika gambar ingin di update
                // Hapus image lama
                Storage::disk('local')->delete('public/news/' . basename($news->image));

                // Upload image baru
                $image = $request->file('image');
                $image->storeAs('public/news/', $image->hashName());

                // Update data
                $news->update([
                    'title' => $request->title,
                    'slug' => Str::slug($request->title),
                    'category_id' => $request->category_id,
                    'image' => $image->hashName(),
                    'content' => $request->content,
    
                ]);
            }

            return ResponseFormatter::success(
                $news,
                'data news berhasil di update'
            );
        } catch (\Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went Wrong',
                'error' => $error
            ], 'Authentication', 500);
        }
    }

    public function destroy($id){
        try {
            //Get data id
            $news = News::findOrFail($id);
            //Delete Id
            Storage::disk('local')->delete('public/news' . basename($news->image));

            $news->delete();

            return ResponseFormatter::success([
                $news,
                'data Berhasil di hapus'
            ]);
        } catch (\Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Authentication', 500);
        }
    }
}
