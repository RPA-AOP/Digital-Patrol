<?php

namespace App\Http\Controllers;

use App\Helpers\Permission;
use App\Models\MasterCompany;
use App\Models\UserGroup;
use App\Models\UserGroupPrivilege;
use App\Models\Users;
use Hash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Factory|View|Application
    {
        $permission = Permission::get();
        if ($permission->has_view) {
            $data = ['permission' => $permission];
            if ($permission->has_create) {
                $data['userGroup'] = UserGroup::with('privilages', 'privilages.menu')->whereStatus(1)->get();
                $data['company'] = MasterCompany::whereStatus(1)->select(['id_company', 'company_name'])->get();
            }
            return view('modules.users.index', $data);
        } else {
            return abort(403, 'Anda tidak memiliki akses pada menu ini');
        }
    }

    public function list()
    {
        $permission = Permission::get();
        if (!$permission->has_view) {
            return response()->json([
                'status' => 'error',
                'msg' => 'anda tidak memiliki akses untuk melakukan operasi ini'
            ]);
        }

        $data = Users::with('userGroup', 'company')->get();
        return DataTables::of($data)->addIndexColumn()->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'user-fullname' => 'required|max:255',
            'user-npk' => 'required',
            'user-email' => 'required',
            'user-phone' => 'required',
            'user-group' => 'required',
            'user-name' => 'required',
            'default-password' => 'required|confirmed',
        ]);
        $newUser = new Users();
        $newUser->name = $request->post('user-fullname');
        $newUser->username = $request->post('user-name');
        $newUser->npk = $request->post('user-npk');
        $newUser->phone = $request->post('user-phone');
        $newUser->id_user_group = $request->post('user-group');
        $newUser->email = $request->post('user-email');
        $newUser->password = Hash::make($request->post('default-password'));
        if ($request->post('user-company') != null) {
            $newUser->id_company = $request->post('user-company');
        }
        if ($request->post('area') != null) {
            $newUser->area = $request->post('area');
        }
        if ($newUser->save()) {
            $newUser->refresh();
            return response()->json(['status' => 'New User created', 'user' => $newUser->toArray()], 200);
        }
        return response()->json(['status' => 'Add New user failed',], 500);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $user = Users::query()->where('id_user', $id)->with('privileges')->first();
        return view('modules.users.profile', compact('user'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('modules.users.profile', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(int $id): Factory|View|Application
    {
        $user = Users::query()->where('id_user', $id)->with('privileges.menu', 'userGroup')->first();
        $userGroup = UserGroup::query()->where('status', 1)->get();
        return view('modules.users.edit', compact('user', 'userGroup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $user = Users::find($id);
        $user->id_user_group = $request->userGroup;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->npk = $request->npk;

        if ($user->save()) {
            return redirect()->route('management-user.show', ['id' => $id])
                ->with('success', 'User Berhasil Di Update');
        }
        return redirect()->route('management-user.show', ['id' => $id])
            ->with('error', 'User Gagal Di Update');
    }

    public function updateUserGroup(Request $request, $id): RedirectResponse
    {
        $permission = Permission::get();
        if (!$permission->has_edit) {
            return abort(403, 'You dont have permission to access this feature');
        }

        if ($request->privilege) {
            foreach ($request->privilege as $key => $privilege) {
                UserGroupPrivilege::whereIdUserGroupPrivilege($key)
                    ->whereIdUserGroup($id)
                    ->update([
                        'has_view' => array_key_exists('has_view', $privilege),
                        'has_edit' => array_key_exists('has_edit', $privilege),
                        'has_create' => array_key_exists('has_create', $privilege),
                        'has_delete' => array_key_exists('has_delete', $privilege),
                    ]);
            }
        }

        return redirect()->route('management-user.index')
            ->with('success', 'User group has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
