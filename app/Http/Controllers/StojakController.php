<?php

namespace App\Http\Controllers;

use App\Stojak;
use Illuminate\Http\Request;

class StojakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Stojak::all();
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
        Stojak::create($request -> all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Stojak  $stojak
     * @return \Illuminate\Http\Response
     */
    public function show(Stojak $stojak)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stojak  $stojakt
     * @return \Illuminate\Http\Response
     */
    public function edit(Stojak $stojak)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stojak  $stojak
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stojak $stojak)
    {
        Stojak::update($request -> all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stojak  $stojak
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stojak $stojak)
    {
        $stojak->delete();
    }
}
