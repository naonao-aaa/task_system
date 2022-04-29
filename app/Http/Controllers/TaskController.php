<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Comment;
use App\Http\Requests\StoreTaskForm;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categoryId = $request->input('category');

        $search = $request->input('search');

        $query = Task::with(['status', 'category', 'user']);  //Eagerローディング

        if (isset($categoryId)) {
            $query->where('category_id', $categoryId);   //カテゴリで条件指定

            //もしキーワードがあったら
            if ($search !== null) {
                //全角スペースを半角に
                $search_split = mb_convert_kana($search, 's');
                //空白で区切る
                $search_split2 = preg_split('/[\s]+/', $search_split, -1, PREG_SPLIT_NO_EMPTY);
                //単語をループで回す
                foreach ($search_split2 as $value) {
                    $query->where('name', 'like', '%' . $value . '%');
                }
            };

            $query->orderBy('created_at', 'asc');
            $tasks = $query->paginate(10);

            if ($tasks->count() === 0) {
                $category = '登録がありません';
            } else {
                $i = 0;
                foreach ($tasks as $task) {
                    if ($i >= 1) {
                        break;
                    }
                    $category = $task->category->name;
                    $i++;
                }
            }
        } else {

            //もしキーワードがあったら
            if ($search !== null) {
                //全角スペースを半角に
                $search_split = mb_convert_kana($search, 's');
                //空白で区切る
                $search_split2 = preg_split('/[\s]+/', $search_split, -1, PREG_SPLIT_NO_EMPTY);
                //単語をループで回す
                foreach ($search_split2 as $value) {
                    $query->where('name', 'like', '%' . $value . '%');
                }
            };

            $category = 'すべてのカテゴリ';

            $query->orderBy('created_at', 'asc');
            $tasks = $query->paginate(10);
        }


        return view('task.index', compact('tasks', 'category', 'categoryId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('task.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskForm $request)
    {
        $task = Task::create([
            'name' => $request->input('task_name'),
            'description' => $request->input('description'),
            'user_id' => $request->input('user'),
            'category_id' => $request->input('category'),
            'status_id' => $request->input('status'),
            'progress' => $request->input('progress'),
            'deadline' => $request->input('deadline')
        ]);

        return redirect(route('task.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        $comments = Comment::with(['task', 'user'])->where('task_id', $task->id)->get();

        return view('task.show')
            ->with(['task' => $task, 'comments' => $comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        return view('task.edit')
            ->with('task', $task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTaskForm $request, Task $task)
    {
        $task->name = $request->input('task_name');
        $task->description = $request->input('description');
        $task->category_id = $request->input('category');
        $task->status_id = $request->input('status');
        $task->progress = $request->input('progress');
        $task->man_hours = $request->input('man_hours');
        $task->deadline = $request->input('deadline');

        $task->save();

        return redirect('task/index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect('task/index');
    }
}
