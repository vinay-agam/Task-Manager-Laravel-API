<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Task::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'string|required|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|mimes:pdf,doc,docx|max:2048',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        $taskData = $request->only(['title', 'description', 'status']);

        if($request->hasFile('file')){
            $taskData['file_path'] = $request->file('file')->store('files', 'public');
        }

        if($request->hasFile('image')){
            $taskData['image_path'] = $request->file('image')->store('images', 'public');
        }

        $task = Task::create($taskData);
        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $task = Task::find($id);
       if(!$task){
           return response()->json(['message' =>'Task Not found'], 404);
       }
       return response()->json($task, 200);
    }

    public function update(Request $request, string $id)
    {

        $task = Task::find($id);
        if(!$task){
            return response()->json(['message' =>'Task Not found'], 404);
        }
        $request->validate([
            'title' => 'string|required|max:255',
            'description' => 'nullable|string',
            'status' => 'in:pending,completed',
            'file' => 'nullable|mimes:pdf,doc,docx|max:2048',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',

        ]);
        $task->update($request->only(['title', 'description', 'status']));

        if ($request->hasFile('file')) {
            $task->update(['file_path' => $request->file('file')->store('files', 'public')]);
        }

        if ($request->hasFile('image')) {
            $task->update(['image_path' => $request->file('image')->store('images', 'public')]);
        }

        return response()->json($task, 200);

    }


    public function destroy(string $id)
    {
        $task= Task::find($id);
        if(!$task){
            return response()->json(['message' =>'Task Not found'], 404);
        }
        $task->delete();

        return response()->json(['message' => 'Task Deleted'], 200);
    }
}
