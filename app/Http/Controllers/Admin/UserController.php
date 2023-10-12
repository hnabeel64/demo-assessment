<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Domain;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $user;
    protected $subdomain;

    public function __construct() {
        $this->user = new User();
        $this->subdomain = Arr::first(explode('.', request()->getHost()));
    }

    public function index()
    {
        $users = $this->user::where('role_id', $this->user::USER)
        ->whereHas('domains', function($q){
            $q->where('domain_name', $this->subdomain);
        })
        ->get();
        return view('Admin.Users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddUserRequest $request)
    {
        try {
            $request->merge(['role_id' => 3]);
        $subdomainId = Domain::where('domain_name', $this->subdomain)->value('id');
        $this->user::create($request->input())->domains()->attach($subdomainId);
        return redirect()->route('users.index', $this->subdomain)->with('success', 'User Created Successfully');
        } catch (Exception $th) {
            return back()->withErrors($th->getMessage());
        }
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
    public function edit(string $subdomain, $id)
    {
        $user = User::findOrFail($id);
        return view('Admin.Users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $subdomain, $id)
    {
        if($request->password === null || ''){
            $request = $request->except(['password']);
            $this->user::find($id)->update($request);
            return redirect()->route('users.index', $this->subdomain)->with('success', 'User Updated Successfully');
        }
        else{
            $request->password = Hash::make($request->password);
            $this->user::find($id)->update($request->only($this->user->getFillable()));
            return redirect()->route('users.index' , $this->subdomain)->with('success', 'User Updated Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $subdomain, $id)
    {
        $this->user->find($id)->delete();
        return back()->with('success', 'User Deleted Successfully');
    }
}
