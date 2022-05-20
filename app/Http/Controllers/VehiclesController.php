<?php

namespace App\Http\Controllers;

use Auth;
use App\Make;
use App\Vehicle;
use App\Manufacturer;
use Illuminate\Http\Request;
use App\Http\Requests\VehicleFormRequest;

class VehiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('modules.vehicles.list', [
            'els' => Auth::user()->vehicles,
            'manufacturers' => Manufacturer::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modules.vehicles.form', [
            'manufacturers' => Manufacturer::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VehicleFormRequest $request)
    {
        $isSuccess = false;

        $vehicle = new Vehicle([
        	'id_number' => $request{'idNumber'},
            'hash' => ''
        ]);

        // dd($vehicle);

        if ($vehicle) {
            $vehicle->make()->associate(Make::where('hash', $request{'make'})->firstOrFail());
            $vehicle->user()->associate(Auth::user());

            if ($vehicle->save()) {
            	activity()->performedOn($vehicle)->causedBy(Auth::user())->log('Добавено ново превозно средство.');
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
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vehicle = Vehicle::where('hash', $id)->firstOrFail();

        $vehicle->make()->associate(Make::where('hash', $request->make)->firstOrFail());
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
        $vehicle = Vehicle::where('hash', $id)->firstOrFail();

        $vehicle->make()->associate(Make::where('hash', $request->make)->firstOrFail());

        if ($vehicle->save()) {
        	activity()->performedOn($vehicle)->causedBy(Auth::user())->log('Редакция на превозно средство.');
            return redirect('vehicles');
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vehicle = Vehicle::where('hash', $id)->firstOrFail();

        if ($vehicle->delete()) {
        	activity()->performedOn($vehicle)->causedBy(Auth::user())->log('Изтриване на превозно средство.');
            return redirect('vehicles');
        }

        return back();
    }
}
