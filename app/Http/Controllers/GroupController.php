<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Resources\GroupResource;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify');
    }
    public function index()
    {
        return GroupResource::collection(Group::where('admin_id',auth()->user()->id)->latest()->paginate(8));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required|string',
            'banner'=>'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        if($request->file('banner'))
        {
            $image = $request->file('banner');
            $name = request('name');
            $filename = $name . time() . '.' . $image->getClientOriginalExtension();
            Image::make($request->file('banner'))->save(public_path('uploads/images/').$filename);
        }else{
            return response()->json(["message"=>"no llega"]);
        }
        Group::create([
            'name'=>$name,
            'banner'=>$filename,
            'admin_id'=>auth()->user()->id,

        ]);
        return response()->json(['message'=>"created","state"=>true,'code'=>200]);
    }
    public function show($id)
    {
        return GroupResource::make(Group::findOrFail($id));
    }
    public function edit(Group $group)
    {
        //
    }
    public function update(Request $request, Group $group)
    {
        //
    }
    public function destroy(Group $group)
    {
        //
    }
}
