<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EvenNumbersController extends Controller
{
    /**
     * Display the even numbers form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('even-numbers');
    }

    /**
     * Generate even numbers within a range.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start' => 'required|integer|min:0',
            'end' => 'required|integer|gte:start|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->route('even-numbers')
                ->withErrors($validator)
                ->withInput();
        }

        $start = (int) $request->input('start');
        $end = (int) $request->input('end');
        
        // Ensure start is even
        if ($start % 2 !== 0) {
            $start++;
        }
        
        $evenNumbers = [];
        for ($i = $start; $i <= $end; $i += 2) {
            $evenNumbers[] = $i;
        }

        return view('even-numbers', compact('evenNumbers', 'start', 'end'));
    }
}