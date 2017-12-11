<?php

namespace App\Service;

use Illuminate\Support\Facades\DB;

class StudentService
{

    public function studentInsert($date)
    {
        if (DB::table('students')->insert($date))
            return true;
        else
            return false;
    }

    public function isStudentExist($studentMobile)
    {
        $student=DB::table('students')->where('mobile','=',$studentMobile)->first();
        if ($student!=null)
            return $student->id;
        else
            return false;
    }
    public function studentUpdate($id,$date)
    {
        if (!DB::table('students')->where('id','=',$id)->update($date))
            return true;
        else
            return false;
    }


}