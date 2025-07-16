<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoachingController extends Controller
{
    /**
     * Display a listing of the coaching sessions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Logic to retrieve and display coaching sessions
        return view('coaching');
    }

    /**
     * Book a new coaching session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function book(Request $request)
    {
        // Logic to handle booking a coaching session
        return redirect()->route('coaching.index')->with('success', 'Coaching session booked successfully.');
    }
}
