<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Work;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
class ReportController extends Controller
{
    private function isAdminByEmail($email)
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
    public function updateScore(Request $request, $id)
    {
        $request->validate([
            'score' => 'required|numeric|min:0',
        ]);
    
        $work = Work::findOrFail($id);
    
        $work->score = $request->input('score');
        $work->save();
    
        return response()->json(['success' => true]);
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
        $user = Auth::user();

        return view('request', compact('categories', 'user'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'path_img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);
    
        if (Work::where('user_id', Auth::id())->exists()) {
            return redirect()->back()->with('error', 'Вы уже отправили работу. Желаем удачи!');
        }
    
        if ($request->hasFile('path_img')) {
            $imageName=Storage::disk('public')->put('/reports',$request->file('path_img'));
            $imageName=time() . '.' . $request['path_img']->extension();
            $request['path_img']->move(public_path('storage'),$imageName);
    
            Work::create([
                'title' => $data['title'],
                'path_img' => $imageName, 
                'score' => "0",
                'category_id' => $data['category_id'],
                'user_id' => Auth::id(),
            ]);
    
            return redirect('/')->with('message', 'Создание заявки успешно!');
        } else {
            return redirect()->back()->with('error', 'Файл не загружен. Пожалуйста, попробуйте еще раз.');
        }
    }
    
    

}
