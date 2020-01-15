<?php

namespace App\Http\Controllers;

use App\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('kriteria.kriteria_index')->render();
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
        $store = Kriteria::create($request->all());
        if (! $store) {
            return response(['erorrs', 'Bad Request.'], 400);
        }
        return response(['success', 'Created'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Kriteria  $kriteria
     * @return \Illuminate\Http\Response
     */
    public function show(Kriteria $kriteria)
    {
        return response($kriteria->all(), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kriteria  $kriteria
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Kriteria $kriteria)
    {
        return response($kriteria->find($request->id), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kriteria  $kriteria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kriteria $kriteria)
    {
        $data = Kriteria::find($request->id);
        if (! $data) {
            return response(['erorrs', 'Bad Request.'], 400);
        }
        $data->update($request->all());
        return response(['success', 'Accepted'], 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kriteria  $kriteria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Kriteria $kriteria)
    {
        $delete = Kriteria::destroy($request->id);
        if (! $delete) {
            return response(['erorrs', 'Bad Request.'], 400);
        }
        return response(['success', 'Accepted'], 202);
    }
}
