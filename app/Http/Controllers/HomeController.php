<?php

namespace App\Http\Controllers;
use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function about()
    {
        return view('about');
    }

    public function services()
    {
          return view('services', ['services' => Service::all()]);
    }

    public function contact()
    {
        return view('contact');
}

}