<?php
/**
 * Created by PhpStorm.
 * User: gits
 * Date: 5/23/17
 * Time: 7:02 PM
 */
/**
 * Created by PhpStorm.
 * User: gits
 * Date: 5/23/17
 * Time: 4:24 AM
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use App\Permission;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $permissions = Permission::orderBy('id', 'DESC')->paginate(10);
        return view('permissions.index', compact('permissions'))
            ->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function create()
    {
        return view('permissions.create');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'display_name' => 'required',
            'description' => 'required',
        ]);

        $permission = new Permission();
        $permission->name = $request->input('name');
        $permission->display_name = $request->input('display_name');
        $permission->description = $request->input('description');
        $permission->save();

        return redirect()->route('permissions.index')
            ->with('success','Permission created successfully');
    }


    public function show($id)
    {
        $permission = Permission::find($id);
        return view('permissions.show',compact('permission'));
    }

    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('permissions.edit',compact('permission'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'display_name' => 'required',
            'description' => 'required',
        ]);

        $permission = Permission::find($id);
        $permission->name = $request->input('name');
        $permission->display_name = $request->input('display_name');
        $permission->description = $request->input('description');
        $permission->save();

        return redirect()->route('permissions.index')
            ->with('success','Permission updated successfully');
    }


    public function destroy($id)
    {
        Permission::find($id)->delete();
        return redirect()->route('permissions.index')
            ->with('success','Permission deleted successfully');
    }


}