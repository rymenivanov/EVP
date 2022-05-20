<?php

namespace App\Http\Controllers;

use Auth;
use App\Trip;
use Illuminate\Http\Request;
use App\Http\Request\TripFormRequest;

class TripsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('modules.trips.list', [
            'els' => Trip::paginate(25)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect('/');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TripFormRequest $request)
    {
        $isSuccess = false;
        $trip = Trip::create([
            'start_point' => $request->start,
            'end_point' => $request->end,
            'details' => $request->all(),
            'hash' => ''
        ]);

        if ($trip) {
            $trip->user()->associate(Auth::user());

            if ($trip->save()) {
                activity()->performedOn($vehicle)->causedBy(Auth::user())->log('Добавено нoво пътуване.');
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
        return redirect('/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect('/');
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
        $trip = Trip::where('hash', $id)->firstOrFail();

        $trip->start = $request->start;
        $trip->end = $request->end;
        $trip->details = $request->all();

        if ($trip->save()) {
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $trip = Trip::where('hash', $id)->firstOrFail();

        if ($trip->delete()) {
            activity()->performedOn($vehicle)->causedBy(Auth::user())->log('Успешно изтрити данни за пътуване.');
            return back();
        }
    }
}
