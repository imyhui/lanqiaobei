<?php
/**
 * Created by PhpStorm.
 * User: lyh
 * Date: 18/1/13
 * Time: 下午4:43
 */

namespace App\Service;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OnlineStudentService
{
    public function studentInsert($date)
    {
        $time = new Carbon();
        $date['created_at'] = $time;
        if (DB::table('online_students')->insert($date))
            return true;
        else
            return false;
    }

    public function isStudentExist($studentMobile)
    {
        $student=DB::table('online_students')->where('mobile','=',$studentMobile)->first();
        if ($student!=null)
            return $student->id;
        else
            return false;
    }
    public function studentUpdate($id,$date)
    {
        $time = new Carbon();
        $date['updated_at'] = $time;
        if (DB::table('online_students')->where('id','=',$id)->update($date))
            return true;
        else
            return false;
    }

}