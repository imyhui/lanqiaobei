<?php

namespace App\Http\Controllers;

use App\Service\OnlineStudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OnlineStudentController extends Controller
{
    public $studentService;
    public function __construct(OnlineStudentService $studentService)
    {
        $this->studentService=$studentService;
    }
    public function formPost(Request $request)
    {
        $rules=[
            'name' => 'required',
            'sex' => 'required',
            'school' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'department' => 'required',
            'major' => 'required',
            'chuankeId' => 'required',
            'orderId' => 'required',
            'refundType' => 'required',
            'refundId' => 'required',
            'ojId' => 'required'
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
