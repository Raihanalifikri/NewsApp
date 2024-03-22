<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(){
        // get All Category
        $category = Category::latest()->get();
        return ResponseFormatter::success([
            $category,
            'Data Category Berhasil Diambil'
        ]);
        



        try {
        } catch (\Exception $error) {
            return ResponseFormatter::error([
                'massage' => 'Someting went Wrong',
                'error' => $error
            ], 'Auththentication Failed', 500);
        }
    }

    public function show($id){
        try {
            //Get data by id
            $category = Category::findOrFail($id);
            return ResponseFormatter::success([
                $category,
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
