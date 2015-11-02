<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostFormRequest;

use Illuminate\Http\Request;

class PostController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $posts = Post::whereActive(1)->orderBy('created_at', 'desc')->paginate(5);
        return view('home')->withPosts($posts)->withTitle('Latest Posts');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if ($request->user()->canPost){
            return view('posts.create');
        } else {
            return redirect('/')->withErrors('You do not have sufficient permissions to writing posts');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(PostFormRequest $request)
    {
        $post = new Post();
        $post->title = $request->get('title');
        $post->body = $request->get('body');
        $post->slug = str_slug($post->title);
        $post->author_id = $request->user()->id;
        if ($request->has('save')){
            $post->active = 0;
            $message = 'Post saved successfully';
        } else {
            $post->active = 1;
            $message = 'Post published successfully';
        }
        $post->save();
        return redirect('edit/'.$post->slug)->withMessage($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($slug)
    {
        $post = Posts::whereSlug($slug)->first();
        if (!$post){
            return redirect('/')->withErrors('requested page not found');
        }
        return view('posts.show')->withPost($post)->withComments($comments);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $post = Post::whereSlug('slug', $slug)->first();
        if (!$this->canModify($post, $request->user)){
            return redirect('/')->withErrors('You do not have sufficient permissions to edit this post');
        }
        return $view('posts.edit')->with('post',$post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        if(!$this->canModify($post, $request->user())){
            return redirect('/')->withErrors('You do not have sufficient permissions to edit this post');
        }
        $title = $request->input('title');
        $slug = str_slug($title);
        $duplicate = Post::where('slug',$slug)->first();
        if($duplicate && $duplicate->id != $post_id){
            return redirect('edit/'.$post->slug)->withErrors('Title already exists.')->withInput();
        }
        $post->slug = $slug;
        $post->title = $title;
        $post->body = $request->input('body');
        if($request->has('save')){
            $post->active = 0;
            $message = 'Post saved successfully';
            $landing = 'edit/'.$post->slug;
        } else {
            $post->active = 1;
            $message = 'Post updated successfully';
            $landing = $post->slug;
        }
        $post->save();
        return redirect($landing)->withMessage($message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $post = Post::find($id);
        if (!$this->canModify($post, $request->user()){
            return redirect('/')->withErrors('You do not have permissions to delete this post');
        }
        $post->delete();
        return redirect('/')->withMessage('Post deleted successfully');
    }

    private function canModify($post, $user){
        return $post && ($user->isAdmin || $post->user_id == $user->id);
    }
}
