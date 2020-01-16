<?php

namespace App\Http\Controllers;

use App\Alternatif;
use Illuminate\Http\Request;

class AlternatifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('alternatif.alternatif_index')->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $store = Alternatif::create([
            'name' => $request->name,
            'nilai_kriteria' => $request->data
        ]);
        if (! $store) {
            return response(['erorrs', 'Bad Request.'], 400);
        }
        return response(['success', 'Created'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Alternatif  $alternatif
     * @return \Illuminate\Http\Response
     */
    public function show(Alternatif $alternatif)
    {
        return response($alternatif->all(), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Alternatif  $alternatif
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Alternatif $alternatif)
    {
        return response($alternatif->find($request->id), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Alternatif  $alternatif
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Alternatif $alternatif)
    {
        $data = Alternatif::find($request->id);
        if (! $data) {
            return response(['erorrs', 'Bad Request.'], 400);
        }
        $data->update([
            'name' => $request->name,
            'nilai_kriteria' => $request->data
        ]);
        return response(['success', 'Accepted'], 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Alternatif  $alternatif
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Alternatif $alternatif)
    {
        $delete = Alternatif::destroy($request->id);
        if (! $delete) {
            return response(['erorrs', 'Bad Request.'], 400);
        }
        return response(['success', 'Accepted'], 202);
    }
}
