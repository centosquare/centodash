<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return View
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Media $media)
    {
        $posts = Post::all();
        $images = $media->get();
        return view('admin.post.index')->with(['posts' => $posts, 'images' => $images]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StorePostRequest  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $post = Post::create(['name' => $request->name]);
            foreach ($request->input('image', []) as $file) {
                $post->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('post.image');
            }

            if ($post) {
                return redirect()->back()->withSuccess('Posts Created successfully');
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
     * @param  \App\Models\Post  $post
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        try {
            $is_delete = $post->delete();
            if ($is_delete) {
                return back()->with('success', 'File deleted successfully.');
            } else {
                return back()->with('error', 'File not found.');
            }
        } catch (Exception $ex) {
            return back()->with('error', 'Something went wrong!');
        }
    }
}
