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
            'email' => 'required',
            'teacher' => 'required'
        ];
        $message=[
            'required' => 'The :attribute field is required.',
        ];
        $validator=Validator::make($request->all(),$rules,$message);
        if ($validator->fails())
            return response()->json([
                'code' =>101,
                'message'=> $validator->errors()
            ]);
        $date=[];
        foreach ($rules as $key => $value)
        {
            $date[$key]=$request->input($key);
        }
        $id=$this->studentService->isStudentExist($date['mobile']);
        if (!$id) {
            if ($this->studentService->studentInsert($date))
                return response()->json([
                'code' => 0,
                'message' => 'insert success'
                 ]);
            else
                return response()->json([
                    'code' => 100,
                    'message' => 'insert date error'
                ]);
        }
        else {
            if ($this->studentService->studentUpdate($id, $date))
                return response()->json([
                'code' =>0,
                'message' => 'update success'
            ]);
            else
                return response()->json([
                    'code' => 0,
                    'message' => 'update date error'
                ]);
        }

    }
}
