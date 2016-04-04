<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

use App\Http\Requests;
use App\Task;


class TaskController extends Controller
{

  // Set Auth Middleware for All but Patient Index.  Add admin only to delete
  public function __construct()
  {
    $this->middleware('auth');
  }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::orderBy('id', 'desc')->get();
        return view('tasks.index')->withTasks($tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
          'name' => 'required|max:255',
        ));

        $task = new Task;
        $task->name = $request->name;
        $task->description = $request->description;
        $task->status = 0;

        $task->save();

        Session::flash('success', 'The task has been added');

        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);
        return view('tasks.show')->withTask($task);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);
        return view('tasks.edit')->withTask($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, array(
          'name' => 'required|max:255'
        ));

        $task = Task::find($id);

        $task->name = $request->name;
        $task->description = $request->description;

        $task->save();

        Session::flash('sucess', 'The task was updated');

        return redirect()->route('tasks.show', $task->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();

        Session::flash('success', 'The Task was deleted');
        return redirect()->route('tasks.index');
    }


    /**
     * Change the status of a Task to Completed (1)
     *
     **/
     public function changeStatus(Request $request) {

       $task = Task::find($request->id);
       if($task->status==1) $task->status = 0;
       else $task->status =1;
       $task->save();

       return response()->json(['outcome'=>'success']);
     }

}
