<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddDomainRequest;
use App\Http\Requests\UpdateDomainRequest;
use App\Models\Domain;
use App\Models\User;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    protected $domain;
    protected $users;

    public function __construct() {
        $this->users = new User();
        $this->domain = new Domain();
    }

    public function index()
    {
        $domains = $this->domain::with('users')->get();
        return view('SuperAdmin.Domain.index', compact('domains'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role_id', $this->users::ADMIN)
        ->where('role_id', '!=', $this->users::SUPERADMIN)
        ->get();
        return view('SuperAdmin.Domain.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddDomainRequest $request)
    {
        $domain = $this->domain::create($request->only($this->domain->getFillable()));
        if($request->has('user_id')){
            $domain->users()->attach($request->user_id);
        }
        return redirect()->route('domains.index')->with('success', 'Domain Created Successfully');
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
        $users = $this->users::whereNotIn('role_id',[$this->users::SUPERADMIN, $this->users::USER])->get();
        $domain = $this->domain::findOrFail($id);
        return view('SuperAdmin.Domain.edit', compact('domain','users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDomainRequest $request, string $id)
    {
        $domain = $this->domain->find($id);
        if($request->has('user_id') && count($request->user_id) > 0){
            foreach ($request->user_id as $key => $value) {
                if($domain->users()->where('user_id', $value)->exists()){
                    $domain->users()->sync($value);
                }
                else{
                    $domain->users()->attach($value);
                }
            }
        }
        else{
            $domain->users()->detach($id);
        }
        $domain->update($request->only($this->domain->getFillable()));
        return redirect()->route('domains.index')->with('success', 'Domain Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->domain->find($id)->delete();
        return back()->with('success', 'Domain Deleted Successfully');
    }
}
