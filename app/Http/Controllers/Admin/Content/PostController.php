<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\PostRequest;
use App\Http\Services\Image\ImageService;
use Illuminate\Http\Request;
use App\Models\Content\Post;
use App\Models\Content\PostCategory;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function __construct(){
    //     $this->authorizeResource(Post::class, 'post');
    // }
    
     public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.content.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->authorize('create', Post::class);
        $postCategories = PostCategory::all();
        return view('admin.content.post.create', compact('postCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request, ImageService $imageService)
    {
        $inputs = $request->all();
        // میخواهیم تایم استمپ را اصلاح کنیم
        $realTimestampStart = substr($request->published_at, 0 ,10);
        $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart); 

        if($request->hasFile('image'))
        {
            $imageService->setExclusiveDirectory('images'.DIRECTORY_SEPARATOR.'post');
            // $result = $imageService->save($request->file('image'));
            // $result = $imageService->fitAndSave($request->file('image'), 600, 150);
            // exit;
            $result = $imageService->createIndexAndSave($request->file('image'));

            if($result === false)
            {
                return redirect(route('admin.content.post.index'))->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            
            $inputs['image'] = $result;
        }

        $inputs['author_id'] = auth()->user()->id;
        $post = Post::create($inputs);
       return redirect()->route('admin.content.post.index')->with('swal-success', 'پست جدید با موفقیت ثبت شد');
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
    public function edit(Post $post)
    {
        $postCategories = PostCategory::all();
        return view('admin.content.post.edit', compact(['post', 'postCategories']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post, ImageService $imageService)
    {
        // روش اول بررسی gate
        // if(!Gate::allows('update-post', $post)){
        //     abort(403);
        // }

        // روش دوم بررسی gate
        // وقتی گیت ریسپانس میفرسته
        // $response = Gate::inspect('update-post');
        // if($response->allowed()){
        //     // عملیات ویرایش
        // }else{
        //     dd($response->message());
        // }

        // if(!Gate::forUser($user)->allows('update-post', $post)){
        //     abort(403);
        // }

        // if(!Gate::denies('update-post', $post)){
        //     abort(403);
        // }

        // if(Gate::any('update-post', 'delete-post')){
           
        // }

        // if(Gate::none('update-post', 'delete-post')){
           
        // }

        // if(!Gate::authorize('update-post', $post)){
        //     abort(403);
        // }

        // if($request->user()->can('update', $post)){
            
        // }

        // if($request->user()->cannot('update')){
        //     abort(403);
        // }

        // $this->authorize('update' ,$post);

        $inputs = $request->all();

        $realTimestampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);

        // اگر کاربر در ویرایش، عکسی ارسال کرد، یعنی میخواهد عکس قبلی را پاک کند و عکس جدید را جای آن قرار دهد
        if($request->hasFile('image'))
        {
            if(!empty($post->image)){
                // میخواهیم عکس قبلی را پاک کنیم
                $imageService->deleteDirectoryAndFiles($post->image['directory']);
            }

            $imageService->setExclusiveDirectory('images'.DIRECTORY_SEPARATOR.'post');
            $result = $imageService->createIndexAndSave($request->image);

            if($result === false){
                return redirect()->route('admin.content.post.edit', $post)->with('swal-error', 'آپلود تصویر با خطا مواجه شد');   
            }

            $inputs['image'] = $result;
        }

        elseif(isset($inputs['current-image']) && !empty($post->image)){
            $image = $post->image;
            $image['currentImage'] = $inputs['current-image'];
            $inputs['image'] = $image;
        }
        
        $post->update($inputs);
        return redirect()->route('admin.content.post.index')->with('swal-success','پست با موفقیت ویرایش شد');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.content.post.index')->with('swal-success', 'پست با موفقیت حذف شد');
    }

    public function status(Post $post)
    {
        $post->status = $post->status === 1 ? 0 : 1;
        $result = $post->save();

        if($result){
            if($post->status == 0){
                return response()->json(['status'=> true, 'checked' => false]);
            }else{
                return response()->json(['status'=>true, 'checked' => true]);
            }
            
        }else{
            return response()->json(['status' => false]);
        }

    }

    public function commentable(Post $post)
    {
        $post->commentable = $post->commentable === 1 ? 0 : 1;
        $result = $post->save();

        if($result){
            if($post->commentable == 0){
                return response()->json(['commentable'=> true, 'checked' => false]);
            }else{
                return response()->json(['commentable'=>true, 'checked' => true]);
            }
            
        }else{
            return response()->json(['commentable' => false]);
        }

    }
}
