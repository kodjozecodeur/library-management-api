<?php

namespace App\Http\Controllers;

use App\Models\Members;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //retrieve all members
        return Members::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:members',
            'phone' => 'nullable'
        ]);
        return Members::create($request->all());

    }

    /**
     * Display the specified resource.
     */
    public function show(Members $member)
    {
        //
        return $member;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Members $member)
    {
        //
        $member->update($request->all());
        return $member;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Members $member)
    {
        //
        $member->delete();
        return response()->json(['message' => 'Member deleted successfully - No content'], 200);
    }
}
