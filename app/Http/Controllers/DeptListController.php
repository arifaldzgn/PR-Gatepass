<?php

namespace App\Http\Controllers;

use App\Models\deptList;
use App\Http\Requests\StoredeptListRequest;
use App\Http\Requests\UpdatedeptListRequest;

class DeptListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoredeptListRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(deptList $deptList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(deptList $deptList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatedeptListRequest $request, deptList $deptList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(deptList $deptList)
    {
        //
    }
}
