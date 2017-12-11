<?php

namespace App\Http\Controllers;

use App\Service\StudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public $studentService;
    public function __construct(StudentService $studentService)
    {
        $this->studentService=$studentService;
    }
    public function formPost(Request $request)
    {
        $rules=[
            'name' => 'required',
            'major' => 'required',
            'stuId' => 'required',
            'language' => 'required',
            'mobile' => 'required',
            'email' => 'required'
        ];
        $message=[
            'required' => 'The :attribute field is required.',
        ];
        $validator=Validator::make($request->all(),$rules,$message);
        $date=[];
        foreach ($rules as $key => $value)
        {
            $date[$key]=$request->input($key);
        }
        $id=$this->studentService->isStudentExist($date['mobile']);
        if (!$id) {
            $this->studentService->studentInsert($date);
            return response()->json([
                'code' => 0,
                'message' => 'insert success'
            ]);
        }
        else {
            $this->studentService->studentUpdate($id, $date);
            return response()->json([
                'code' =>0,
                'message' => 'update success'
            ]);
        }

    }
}
