<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $user;

    public function __construct() {
        $this->user = new User();
    }

    public function index()
    {
        $admins = $this->user::where('role_id', $this->user::ADMIN)->get();
        return view('SuperAdmin.Admin.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('SuperAdmin.Admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddAdminRequest $request)
    {
        $request->merge(['role_id' => 2]);
        $this->user::create($request->input());
        return redirect()->route('admins.index')->with('success', 'Admin Created Successfully');
    }

    // /**
    //  * Display the specified resource.
    //  */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $admin = User::findOrFail($id);
        return view('SuperAdmin.Admin.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, string $id)
    {
        if($request->password === null || ''){
            $request = $request->except(['password']);
            $this->user::find($id)->update($request);
            return redirect()->route('admins.index')->with('success', 'User Updated Successfully');
        }
        else{
            $request->password = Hash::make($request->password);
            $this->user::find($id)->update($request->only($this->user->getFillable()));
            return redirect()->route('admins.index')->with('success', 'User Updated Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->user->find($id)->delete();
        return back()->with('success', 'Admin Deleted Successfully');
    }
}
