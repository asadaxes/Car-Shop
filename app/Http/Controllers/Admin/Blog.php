<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Blogs;


class Blog extends Controller
{
    public function blogs_list(Request $request)
    {
        $query = Blogs::query();
        $searchTerm = $request->input('search');
        $query->when($searchTerm, function ($query) use ($searchTerm) {
            $query->where('title', 'like', '%' . $searchTerm . '%')
                ->orWhereJsonContains('tags', $searchTerm);
        });
        $blogs = $query->orderBy('id', 'desc')->paginate(30);
        $data = [
            'active_page' => 'blogs_list',
            'blogs' => $blogs
        ];
        return view('admin.blogs_list', $data);
    }

    public function blogs_add()
    {
        $data = [
            'active_page' => 'blogs_add'
        ];
        return view('admin.blogs_add', $data);
    }

    public function blogs_add_handler(Request $request)
    {
        $validatedData = $request->validate([
            'thumbnail' => 'required|image',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tags' => 'required|string',
        ], [
            'thumbnail.required' => 'A thumbnail image is required.',
            'thumbnail.image' => 'The thumbnail must be an image file.',
            'title.required' => 'The title is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'content.required' => 'The content is required.',
            'content.string' => 'The content must be a string.',
            'tags.required' => 'Tags are required.',
            'tags.string' => 'The tags must be a string.',
        ]);
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('blogs', 'public');
        }
        $blog = new Blogs;
        $blog->title = $validatedData['title'];
        $blog->content = $validatedData['content'];
        $blog->thumbnail = $thumbnailPath;
        $blog->tags = json_encode(array_map('trim', explode(',', $validatedData['tags'])));
        $blog->save();
        return redirect()->route('admin_blogs_list')->with('success', 'Blog post has published successfully!');
    }

    public function blogs_edit()
    {
        try {
            $id = request()->query('id');
            $blog = Blogs::findOrFail($id);
            $data = [
                'active_page' => 'blogs_edit',
                'blog' => $blog
            ];
            return view('admin.blogs_edit', $data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin_blogs_list');
        }
    }

    public function blogs_edit_handler(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:blogs,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tags' => 'required|string',
        ], [
            'id.exists' => 'The selected blog ID is invalid.',
            'title.required' => 'The title is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'content.required' => 'The content is required.',
            'content.string' => 'The content must be a string.',
            'tags.required' => 'Tags are required.',
            'tags.string' => 'The tags must be a string.'
        ]);

        $blog = Blogs::findOrFail($validatedData['id']);
        $blog->title = $validatedData['title'];
        $blog->content = $validatedData['content'];
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('blogs', 'public');
            $blog->thumbnail = $thumbnailPath;
        }
        $blog->tags = json_encode(array_map('trim', explode(',', $validatedData['tags'])));
        $blog->save();

        return redirect()->back()->with('success', 'Blog post has been updated successfully!');
    }

    public function blogs_delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:blogs,id'
        ], [
            'id.required' => 'Post ID is required',
            'id.exists' => 'Invalid post ID'
        ]);
        $blog = Blogs::findOrFail($request->id);
        if ($blog->thumbnail) {
            Storage::disk('public')->delete($blog->thumbnail);
        }
        $blog->delete();
        return redirect()->back()->with('success', 'Post deleted successfully');
    }
}