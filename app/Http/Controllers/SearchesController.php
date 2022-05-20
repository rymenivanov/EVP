<?php

namespace App\Http\Controllers;

use Auth;
use App\Search;
use Illuminate\Http\Request;

class SearchesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('modules.search.list', [
            'els' => Auth::user()->searches
        ]);
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
        $request->validate([
            'start' => 'required|array',
            'end' => 'required|array',
            'stops' => 'present|array',
            'preferences' => 'required|array',
            'routeOptions' => 'required|array',
        ]);

        $isSuccess = false;

        $search = Search::create([
            'data' => json_encode($request->all()),
            'hash' => ''
        ]);

        if ($search) {
            $search->user()->associate(Auth::user());
            if ($search->save()) {
                activity()->performedOn($search)->causedBy(Auth::user())->log('Запазени данни за търсене.');
                $isSuccess = true;
            }
        }

        return response()->json(['isSuccess' => $isSuccess]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $search = Search::where('hash', $id)->firstOrFail();

        if ($search->delete()) {
            activity()->performedOn($search)->causedBy(Auth::user())->log('Изтрити данни за търсене.');
            return back();
        }
    }
}
