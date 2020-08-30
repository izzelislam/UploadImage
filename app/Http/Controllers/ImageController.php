<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;

class ImageController extends Controller
{
    public function index()
    {
    	$datas=Image::all();
    	return view('index',compact('datas'));
    }

    public function create()
    {
    	return view('create');
    }
    public function store(Request $request)
    {
    	$image=$request->file('photo_file');
    	$newName=time().'.'.$image->getClientOriginalExtension();

    	$image->move(public_path('img'),$newName);
    	$request->merge(['image_file'=>$newName]);

    	Image::create($request->all());
    	return redirect('/');
    }

    public function destroy($id)
    {
    	$data=Image::find($id);
    	$fullpath=public_path('img').'/'.$data->image_file;

    	if ($data->image_file && file_exists($fullpath)) {
    		unlink($fullpath);
    	}

    	$data->delete();

    	return redirect('/');
    }
}
