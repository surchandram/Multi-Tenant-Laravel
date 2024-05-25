<?php

namespace SAAS\Http\Users\Controllers;

use SAAS\App\Controllers\Controller;
use SAAS\Domain\Users\Models\UserInvitation;
use SAAS\Http\Users\Requests\UserInvitationStoreRequest;
use SAAS\Http\Users\Requests\UserInvitationUpdateRequest;

class UserInvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \SAAS\Http\Users\Requests\UserInvitationStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserInvitationStoreRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \SAAS\Domain\Users\Models\UserInvitation  $userInvitation
     * @return \Illuminate\Http\Response
     */
    public function show(UserInvitation $userInvitation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \SAAS\Domain\Users\Models\UserInvitation  $userInvitation
     * @return \Illuminate\Http\Response
     */
    public function edit(UserInvitation $userInvitation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \SAAS\Http\Users\Requests\UserInvitationUpdateRequest  $request
     * @param  \SAAS\Domain\Users\Models\UserInvitation  $userInvitation
     * @return \Illuminate\Http\Response
     */
    public function update(UserInvitationUpdateRequest $request, UserInvitation $userInvitation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \SAAS\Domain\Users\Models\UserInvitation  $userInvitation
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserInvitation $userInvitation)
    {
        //
    }
}
