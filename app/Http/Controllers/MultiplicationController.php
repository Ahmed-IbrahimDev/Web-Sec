<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MultiplicationController extends Controller
{
    /**
     * Display the multiplication form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('multiplication');
    }

    /**
     * Generate a multiplication table for a number.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required|integer|min:1|max:100',
            'limit' => 'required|integer|min:1|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->route('multiplication')
                ->withErrors($validator)
                ->withInput();
        }

        $number = (int) $request->input('number');
        $limit = (int) $request->input('limit');
        
        $results = [];
        for ($i = 1; $i <= $limit; $i++) {
            $results[] = [
                'multiplier' => $i,
                'result' => $i * $number
            ];
        }

        return view('multiplication', compact('results', 'number', 'limit'));
    }
}