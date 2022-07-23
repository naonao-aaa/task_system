<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Comment;
use App\Http\Requests\StoreTaskForm;
use App\Http\Requests\UpdateTaskForm;
use App\Services\DetailProcess;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Illuminate\Http\Request
     * @return Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $categoryId = $request->input('category') ?? '';  //$request->input('category')が、存在していない(定義されてない)か、NULLの時は、$categoryIdを''(空文字)にする。
        $workUserId = $request->input('work_user') ?? '';
        $search = $request->input('search');

        $pulldownCategories = DetailProcess::categoryAll();
        $pulldownUsers = DetailProcess::userAll();

        $index = DetailProcess::taskIndexQuery($categoryId, $search, $workUserId);   //クエリ処理などの大部分の処理を、サービスに切り離している。

        return view('task.index')
            ->with('tasks', $index['tasks'])
            ->with('category', $index['category'])
            ->with('categoryId', $index['categoryId'])
            ->with('workUserId', $index['workUserId'])
            ->with('pulldownCategories', $pulldownCategories)
            ->with('pulldownUsers', $pulldownUsers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Illuminate\View\View
     */
    public function create(): View
    {
        $users = DetailProcess::userAll();
        $statuses = DetailProcess::statusAll();
        $categories = DetailProcess::categoryAll();

        return view('task.create')
            ->with('users', $users)
            ->with('statuses', $statuses)
            ->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreTaskForm  $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function store(StoreTaskForm $request): RedirectResponse
    {
        $task = Task::create([
            'name' => $request->input('task_name'),
            'description' => $request->input('description'),
            'admin_user' => $request->input('admin_user'),
            'work_user' => $request->input('work_user'),
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
     * @param  App\Task  $task
     * @return Illuminate\View\View
     */
    public function show(Task $task): View
    {
        $comments = Comment::with(['task', 'user'])->where('task_id', $task->id)->get();

        return view('task.show')
            ->with(['task' => $task, 'comments' => $comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Task  $task
     * @return Illuminate\View\View
     */
    public function edit(Task $task): View
    {
        $statuses = DetailProcess::statusAll();
        $categories = DetailProcess::categoryAll();

        return view('task.edit')
            ->with('task', $task)
            ->with('statuses', $statuses)
            ->with('categories', $categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\UpdateTaskForm  $request
     * @param  App\Task  $task
     * @return Illuminate\Http\RedirectResponse
     */
    public function update(UpdateTaskForm $request, Task $task): RedirectResponse
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
     * @param  App\Task  $task
     * @return Illuminate\Http\RedirectResponse
     */
    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect('task/index');
    }
}
