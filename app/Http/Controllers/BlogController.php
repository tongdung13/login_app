<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::query()->paginate(10);
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'image' => 'required',
        ], [
            'title.required' => 'Vui long nhap title',
            'content.required' => 'Vui long nhap noi dung',
            'image.required' => 'Vui long chon hinh anh',
        ]);

        if ($validator->fails()) {
            return redirect()->route('blogs.create')->withInput($request->all())->withErrors($validator->getMessageBag());
        }
        DB::beginTransaction();
        try {
            $blog = new Blog();
            $blog->fill($request->all());
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = md5(time() . rand(0, 999999)) . '.' . $image->getClientOriginalExtension();
                $filePath = 'blogs/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($image));
                $blog->image = 'blogs/' . $name;
            }
            if (!$blog->save()) {
                DB::rollBack();
                return redirect()->route('blogs.create')->withInput($request->all())->withErrors('Co loi xay ra trong qua trinh lu du lieu');
            }
            DB::commit();
            return redirect()->route('blogs.index')->withSuccess('Them moi thanh cong');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('blogs.create')->withInput($request->all())->withErrors('Co loi xay ra');
        }
    }
}
