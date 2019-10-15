<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
/*
 * added by animesh
*/
use Validator;
use Illuminate\Support\Facades\Auth; 
use App\Models\Role;
class RoleController extends Controller
{
    /**
      * Create a new controller instance.
      *
      * @return void
      */
    public function __construct()
    {
        // $this->middleware(['auth:admin', 'admin.verified']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index',['roles'=> $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(Auth::check()){
            $messages = [
                'roleName.required' => 'Please enter the role name!',
            ];

            $validator = Validator::make($request->all(), [
                'roleName' => 'required|unique:roles,name|max:255',
            ], $messages);

            if ($validator->fails()) {
                return redirect()->route('roles.create')
                            ->withErrors($validator)
                            ->withInput();
            }

            $role = Role::create([
                'name' => $request->roleName,
            ]);

            if($role){
                return redirect()->route('roles.index')
                ->with('success' , 'Role created successfully');
            }
        
        }
        return back()->withInput()->with('errors', 'Error creating new Role');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        
        return view('admin.roles.edit', ['role'=>$role]);
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
        $roleUpdate = Role::where('id', $id)
                                  ->update([
                                          'name'=> $request->input('roleName'),
                                  ]);
        
        if($roleUpdate){
            return redirect()->route('roles.index')
            ->with('success' , 'Role updated successfully');
        }
        //redirect
        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $findrole = Role::find($id);
        if($findrole->delete()){
            
            //redirect
            return redirect()->route('roles.index')
            ->with('success' , 'role deleted successfully');
        }
        
        return back()->withInput()->with('error' , 'role could not be deleted');
    }
}
