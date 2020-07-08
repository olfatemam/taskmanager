<?php

namespace App\Helpers;


use Illuminate\Support\Facades\Log;
use Illuminate\Routing\UrlGenerator;

class DBError {

    public static function get_readable_sql_error($e)
    {
        $message="";
        if($e instanceof \PDOException)
        {
            $message = $e->getMessage();
            $my_array  = preg_split("/:/", $message);
        
            //log::info($my_array[2]);
            if($e->getCode()==23000)return "Duplicate Task Name";
            $message = str_replace ("(SQL", "",  $my_array[2]) . $e->getCode();
        }
        return $message;
    }

    public static function report($e)
    {
        $message = self::get_readable_sql_error($e);
        return redirect()->to(app(UrlGenerator::class)->previous())->withErrors(array('message' => $message));
    }
}
