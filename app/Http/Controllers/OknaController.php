<?php

namespace App\Http\Controllers;

use App\Okna;
use Illuminate\Http\Request;

class OknaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Okna::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Okna::create($request -> all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Okna  $okna
     * @return \Illuminate\Http\Response
     */
    public function show(Okna $okna)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Okna  $okna
     * @return \Illuminate\Http\Response
     */
    public function edit(Okna $okna)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Okna  $okna
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Okna $okna)
    {
        Okna::update($request -> all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Okna  $okna
     * @return \Illuminate\Http\Response
     */
    public function destroy(Okna $okna)
    {
        $okna->delete();
    }
}
