<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Storage;

class categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Title halaman Index
        $title = 'Category - Index';

        // Mengurutkan data berdasarkan data terbaru
        $category = Category::latest()->paginate(5);
        return view('home.category.index', compact(
            'category',
            'title'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Title create
        $title = 'Create Index';

        return view('home.category.create', compact(
            'title'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        // melakukan Validasi
        $this->validate($request, [
            'name' => 'required|max:255',
            'image' => 'required|image|mimes: jpeg,png,jpg|max:5048'
        ]);

        // Melakukan Aploud Image
        $image = $request->file('image');
        $image->storeAs('public/category', $image->hashName());

        // Save ke DB
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $image->hashName()
        ]);

        // Melakukan Retrun Redirect
        return redirect()->route('category.index')
            ->with('success', 'Category Berhasil Di Tambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Title edit
        $title = 'Edit Index';

        //Get data by id
        $category = Category::find($id);

        return view('home.category.edit', compact(
            'category',
            'title'
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
        //Melakukan Validasi
        $this->validate($request, [
            'name' => 'required|max:255',
            'image' => 'image|mimes: jpeg,png,jpg|max:5048'
        ]);

        //get data by id
        $category = Category::find($id);
        //jika image kosong
        if ($request->file('image') == '') {
            $category->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name)
            ]);
            return redirect()->route('category.index');
        } else {
            // jika gambar ingin di update
            // Hapus image lama
            Storage::disk('local')->delete('public/category/' .basename($category->image));
            
            // Upload image baru
            $image = $request->file('image');
            $image->storeAs('public/category/', $image->hashName());

            // Update data
            $category->update([
                'name' => $request->name,
                'slug' => Str::slug( $request->name),
                'image' => $image->hashName()
            ]);

            return redirect()->route('category.index')
            ->with('update', 'Category Berhasil Di update');
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //get dadt by id
        $category = Category::find($id);
        
        // Hapus image lama
        // basename itu untuk mengambil nama file
        Storage::disk('local')->delete('public/category/' .basename($category->image));
        
        // Hapus data
        $category->delete();
        
        // Redirect
        return redirect()->route('category.index')
        ->with('delete', 'Category Berhasil Di hapus');
    }
}
