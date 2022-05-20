<?php

namespace App\Policies;

use App\User;
use App\Vehicle;
use Illuminate\Auth\Access\HandlesAuthorization;

class VehiclePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the vehicle.
     *
     * @param  \App\User  $user
     * @param  \App\Vehicle  $vehicle
     * @return mixed
     */
    public function view(User $user, Vehicle $vehicle)
    {
        return $user->id === $vehicle->user_id;
    }

    /**
     * Determine whether the user can create vehicles.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the vehicle.
     *
     * @param  \App\User  $user
     * @param  \App\Vehicle  $vehicle
     * @return mixed
     */
    public function update(User $user, Vehicle $vehicle)
    {
        return $user->id === $vehicle->user_id;
    }

    /**
     * Determine whether the user can delete the vehicle.
     *
     * @param  \App\User  $user
     * @param  \App\Vehicle  $vehicle
     * @return mixed
     */
    public function delete(User $user, Vehicle $vehicle)
    {
        return $user->id === $vehicle->user_id;
    }
}
