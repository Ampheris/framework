<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class HelloWorldController extends Controller
{
    /**
     * Display a message.
     *
     * @param  string  $message
     * @return View
     */
    public function hello($message=null)
    {
        return view('message', [
            'message' => $message ?? "Hello World as default from within controller"
        ]);
    }
}
