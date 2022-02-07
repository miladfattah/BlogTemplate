<?php

namespace App\Http\Livewire;
use App\Models\Admin\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Posts extends Component
{
    use WithFileUploads ;
    use WithPagination ;


    public $showModalForm = false ; 
    public $title = "" ; 
    public $body = "" ; 
    public $image ;
    public $newImage ; 
    public $postId = null ; 

    public function showCreatePostModal()
    {
        $this->showModalForm  = true ; 
    }

    public function storePost()
    {

        $this->validate([
            'title' => 'required|string' , 
            'body' => 'required|string' , 
            'image' => 'required|image|max:2048'
        ]);

        $image_name = $this->image->getClientOriginalName();
        $this->image->storeAs('public/photos' , $image_name) ; 
        
        Post::create([
            'user_id' => auth()->user()->id , 
            'title' => $this->title , 
            'slug' => Str::slug($this->title) ,  
            'body' => $this->body  , 
            'image' => $image_name  
        ]);

        $this->reset();

        session()->flash('flash.banner' , 'مقاله شما با موفقیت ایجاد شد ');

    }

    public function showEditPostModal($id)
    {
        $this->reset();
        $this->showModalForm  = true ; 
        $this->postId = $id ; 
        $this->loadEditForm();
    }

    public function loadEditForm(){
        $post = Post::findOrFail($this->postId);
        $this->title = $post->title ; 
        $this->body = $post->body ; 
        $this->newImage = $post->image ;  
    }

    public function updatePost(){
        $this->validate([
            'title' => 'required|string' , 
            'body' => 'required|string' , 
            'image' => 'required|image|max:2048'
        ]);

        if($this->image){
            Storage::delete('public/photos/' , $this->newImage) ; 
            $this->newImage =  $this->image->getClientOriginalName();
            $this->image->storeAs('public/photos/' , $this->newImage); 
        }

        Post::find($this->postId)->update([
            'title' => $this->title , 
            'body' => $this->body ,
            'image' => $this->newImage 
        ]);

        $this->reset();

        session()->flash('flash.banner' , 'مقاله شما با موفقیت ویرایش شد');
    }

    public function deletePost($id)
    {
        $post = Post::find($id); 
        Storage::delete('public/photos/' , $post->image);
        $post->delete();

        session()->flash('flash.banner' , 'مقاله شما حذف شد');
    }
    
    public function render()
    {
        return view('livewire.posts' , [
            'posts' => Post::orderBy('created_at' , 'DESC')->paginate(5)
        ]);
    }
}
