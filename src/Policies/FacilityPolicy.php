<?php

namespace Armincms\Facility\Policies;
 
use Illuminate\Contracts\Auth\Authenticatable as User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Armincms\Facility\Facility;

class FacilityPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any facilitys.
     *
     * @param  \Component\Acl\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the facility.
     *
     * @param  \Component\Acl\User  $user
     * @param  \Armincms\Facility\Facility  $facility
     * @return mixed
     */
    public function view(User $user, Facility $facility)
    {
        return \Auth::guard('admin')->check();
    }

    /**
     * Determine whether the user can create facilitys.
     *
     * @param  \Component\Acl\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return  \Auth::guard('admin')->check();
    }

    /**
     * Determine whether the user can update the facility.
     *
     * @param  \Component\Acl\User  $user
     * @param  \Armincms\Facility\Facility  $facility
     * @return mixed
     */
    public function update(User $user, Facility $facility)
    {
        return \Auth::guard('admin')->check();
    }

    /**
     * Determine whether the user can delete the facility.
     *
     * @param  \Component\Acl\User  $user
     * @param  \Armincms\Facility\Facility  $facility
     * @return mixed
     */
    public function delete(User $user, Facility $facility)
    {
        return \Auth::guard('admin')->check();
    }

    /**
     * Determine whether the user can restore the facility.
     *
     * @param  \Component\Acl\User  $user
     * @param  \Armincms\Facility\Facility  $facility
     * @return mixed
     */
    public function restore(User $user, Facility $facility)
    {
        return \Auth::guard('admin')->check();
    }

    /**
     * Determine whether the user can permanently delete the facility.
     *
     * @param  \Component\Acl\User  $user
     * @param  \Armincms\Facility\Facility  $facility
     * @return mixed
     */
    public function forceDelete(User $user, Facility $facility)
    {
        return \Auth::guard('admin')->check();
    } 
}
