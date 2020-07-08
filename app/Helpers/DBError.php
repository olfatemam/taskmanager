<?php

namespace App\Helpers;


use Illuminate\Support\Facades\Log;
use Illuminate\Routing\UrlGenerator;

class DBError {
    //put your code here

    public static function report($e)
    {
        
        $message="";
        if($e instanceof \PDOException)
        {
            $message = $e->getMessage();
            $my_array  = preg_split("/:/", $message);
        
            //log::info($my_array[2]);
            $message = str_replace ("(SQL", "",  $my_array[2]);
        }
        return redirect()->to(app(UrlGenerator::class)->previous())->withErrors(array('message' => $message));
        
    }
    
}
