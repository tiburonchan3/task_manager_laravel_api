<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify');
    }
    public function index()
    {
       return TaskResource::collection(Task::all());
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'task' => 'required|string',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        Task::create([
            'task' => $request->task,
            'state' => 0
        ]);
        return response()->json([
            "message"=>"craeted"
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return TaskResource::make(Task::findOrFail($id));
    }
    public function update(Request $request, $id)
    {
        Task::findOrFail($id)->update([
            'task' => $request->task,
            'state' => $request->state
        ]);
        return response()->json(['message'=>"edit ok"],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::destroy($id);
        return response()->json(['message'=>'deleted ok'],201);
    }
}
