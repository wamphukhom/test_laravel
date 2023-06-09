<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    //
    function index(){
        $city = '123 กรุงเทพ';
        $tel = '0000000000';
        $error = 'ERROR 404';
        // return view('about', ['city'=>$city, 'tel'=>$tel]);
        // return view('about', compact('city', 'tel'));
        return view('about')
        ->with('city', $city)
        ->with('tel', $tel)
        ->with('error', $error);
    }
}
