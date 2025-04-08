<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Work;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{   private function isAdminByEmail($email)
    {
        return Auth::check() && Auth::user()->email === "admin@admin.com";
    }
    
    public function adminIndex()
    {
    if (!$this->isAdminByEmail('admin@example.com')) {
      abort(403, 'Недостаточно полномочий для доступа к этой странице.');
    }
        $works = Work::paginate(10);
        $categories = Category::all();

        return view('admin', compact('works', 'categories'));
    }

    public function updateStatus(Request $request, $id)
    {
        $work = Work::findOrFail($id);
        $work->category_id = $request->input('category_id');
        $work->save();

        return response()->json(['success' => true]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:category,id',
        ]);

        $work = Work::findOrFail($id);
        $work->categories_id = $request->categories_id;
        $work->save();

        return redirect()->route('admin.index')->with('success', 'Статус обновлён успешно!');
    }



    public function index()
    {
        $works = Work::where('user_id', Auth::id())->paginate(10);
        return view('welcome', ['works' => $works]);
    }

    public function create()
    {
        $categories = Category::all();

        return view('request', compact('categories'));  
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'path_img' => 'required|string|max:255',
            'score' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);



        Work::create([
            'title' => $data['title'],
            'path_img' => $data['path_img'],
            'score' => $data['score'],
            'category_id' => $data['category_id'],
            'user_id' => Auth::id(),
        ]);

        Log::info('Report created successfully.');

        return redirect('/')->with('message', 'Создание заявки успешно!');
    }
}
