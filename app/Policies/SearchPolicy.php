<?php

namespace App\Policies;

use App\User;
use App\Search;
use Illuminate\Auth\Access\HandlesAuthorization;

class SearchPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the search.
     *
     * @param  \App\User  $user
     * @param  \App\Search  $search
     * @return mixed
     */
    public function view(User $user, Search $search)
    {
        //
    }

    /**
     * Determine whether the user can create searches.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the search.
     *
     * @param  \App\User  $user
     * @param  \App\Search  $search
     * @return mixed
     */
    public function update(User $user, Search $search)
    {
        //
    }

    /**
     * Determine whether the user can delete the search.
     *
     * @param  \App\User  $user
     * @param  \App\Search  $search
     * @return mixed
     */
    public function delete(User $user, Search $search)
    {
        //
    }
}
