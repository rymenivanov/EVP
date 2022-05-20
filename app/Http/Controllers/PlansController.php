<?php

namespace App\Http\Controllers;

use Auth;
use App\Trip;
use App\Plan;
use Illuminate\Http\Request;
use App\Http\Requests\PlanFormRequest;

class PlansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('modules.plans.list', [
            'els' => Auth::user()->plans
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
    public function store(PlanFormRequest $request)
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
            $trip->save();

            $plan = Plan::create([
                'title' => $request->plan{'title'},
                'on' => new \Carbon\Carbon($request->plan{'dateTime'}),
                'hash' => ''
            ]);

            $plan->trip()->associate($trip);

            if ($plan->save()) {
                activity()->performedOn($plan)->causedBy(Auth::user())->log('Създаден нов план за пътуване.');
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
        $plan = Plan::where('hash', $id)->firstOrFail();

        if ($plan->delete()) {
            activity()->performedOn($plan)->causedBy(Auth::user())->log('Изтрит план за пътуване.');
            return back();
        }
    }
}
