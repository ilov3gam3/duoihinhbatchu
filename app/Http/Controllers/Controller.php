<?php

namespace App\Http\Controllers;

use App\Models\Questions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function get_question(Request $request){
        $question = Questions::where('id', $request->id)->first();
        return response()->json(['data' => $question]);
    }
    public function index(){
        return view('create_question');
    }
    public function create(Request $request){
        if ($request->hasFile('file')){
            $file = $request->file;
            $file_name = Carbon::now()->timestamp . "_" . $file->getClientOriginalName();
            $file->move('upload', $file_name);
            Questions::create([
                'img_path' => '/upload/' . $file_name,
                'answer' => $request->slug
            ]);
            return response()->json(['status' => true, 'path' => '/upload/' . $file_name]);
        } else {
            return response()->json(['status' => false, 'message' => 'éo có file']);
        }
    }
    public function get_question_id(){
        $list = Questions::select('id')->get();
        return response()->json(['data' => $list]);
    }
}
