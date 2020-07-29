<?php

namespace App\Http\Controllers;

use App\Window;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WindowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::table('windows')->leftJoin('stands', 'windows.stand', '=', 'stands.barcode')->select('windows.*', 'stands.site')->get();
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
        Window::create($request -> all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Window  $window
     * @return \Illuminate\Http\Response
     */
    public function show(Window $window)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Window  $window
     * @return \Illuminate\Http\Response
     */
    public function edit(Window $window)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Window  $window
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Window $window)
    {
        Window::update($request -> all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Window  $window
     * @return \Illuminate\Http\Response
     */
    public function destroy(Window $window)
    {
        $window->delete();
    }
}
