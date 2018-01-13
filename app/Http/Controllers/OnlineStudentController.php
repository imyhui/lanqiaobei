<?php

namespace App\Http\Controllers;

use App\Service\OnlineStudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Excel;
use App\OnlineStudent;

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
    public function exportStudent(Request $request)
    {
        if ($request->password != "neuqAcm111") {
            return response()->json([
                'code' => '10000',
                'message' => '密码错误'
            ]);
        } else {
            $data = OnlineStudent::all();
            $title = [
                'id',
                'name',
                'sex',
                'school',
                'email',
                'mobile',
                'department',
                'major',
                'chuankeId',
                'orderId',
                'refundType',
                'refundId',
                'ojId',
                'created_at',
                'updated_at'
            ];
            $cellData[] = $title;
            foreach ($data as $student) {
                $rowdata = [];
                foreach ($title as $key) {
                    $rowdata[] = $student[$key];
                }
                $cellData[] = $rowdata;
            }
            Excel::create('蓝桥杯寒假培训外校报名表', function ($excel) use ($cellData) {
                $excel->sheet('score', function ($sheet) use ($cellData) {
                    $sheet->rows($cellData);
                });
            })->export('xls');
        }
    }
}
