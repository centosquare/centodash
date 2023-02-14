<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileManager;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FileManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return View
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Media $media)
    {
        $files = FileManager::all();
        $images = $media->get();
        return view('admin.file-manager.index')->with(['files' => $files, 'images' => $images]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StorefileRequest  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $file = FileManager::create(['name' => $request->name]);
            foreach ($request->input('image', []) as $file) {
                $file->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('file.image');
            }

            if ($file) {
                return redirect()->back()->withSuccess('File Created successfully');
            } else {
                return back()->withError('Something went wrong!');
            }
        } catch (Exception $ex) {
            return back()->withError($ex->getMessage());
        }
    }


    /**
     * Upload the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\file  $file
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        try {
            $path = storage_path('tmp/uploads');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $file = $request->file('file');

            $name = uniqid() . '_' . trim($file->getClientOriginalName());

            $file->move($path, $name);

            return response()->json([
                'name'          => $name,
                'original_name' => $file->getClientOriginalName(),
            ]);
        } catch (Exception $ex) {
            return redirect()->back()->withError('Something went wrong !');
        }
    }

    /**
     * Get the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getImage($id)
    {
        $image = Media::find($id);
        if ($image) {
            return response()->json(['image_url' => $image->getUrl()]);
        } else {
            return response()->json(['error' => 'Image not found']);
        }
    }
}
