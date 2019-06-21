<?php
    
    
    namespace Weeq\Init\Http\Controllers;
    
    
    class Admin extends Controller
    {
        public function __invoke()
        {
            return view('admin');
        }
    }
