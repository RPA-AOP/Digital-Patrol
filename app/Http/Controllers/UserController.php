<?php

namespace App\Http\Controllers;

use App\Helpers\DashboardHelper;
use App\Helpers\Permission;
use App\Models\DetailPatrolConfig;
use App\Models\MasterCompany;
use App\Models\PatrolActivity;
use App\Models\UserGroup;
use App\Models\UserGroupPrivilege;
use App\Models\Users;
use Hash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash as PasswordHash;
use Illuminate\View\View;
use Spatie\Activitylog\Models\Activity;
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
                $userGroup = UserGroup::with('privilages', 'privilages.menu')->whereStatus(1);
                $company = MasterCompany::whereStatus(1)->select(['id_company', 'company_name']);
                if (\Auth::user()->id_user_group == UserGroup::ADMIN_COMPANY) {
                    $company->where('id_company', \Auth::user()->id_company);
                    $userGroup->whereIn('id_user_group', [3, 4]);
                }

                $data['userGroup'] = $userGroup->get();
                $data['company'] = $company->get();

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

        $data = Users::with('userGroup', 'company', 'patrolArea');
        if (\Auth::user()->id_user_group == UserGroup::ADMIN_COMPANY) {
            $data->where('id_company', \Auth::user()->id_company);
        }
        return DataTables::of($data->get())->addIndexColumn()->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {

        $permission = Permission::get();
        if ($permission->has_create) {
            $request->validate([
                'user-fullname' => 'required|max:255',
                'user-npk' => 'required',
                'user-email' => 'email:rfc,dns|required',
                'user-phone' => 'required|numeric|digits_between:10,15',
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
        return response()->json(['status' => 'Add New user permissions denied',], 403);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function show($id): Factory|View|Application
    {
        $permission = Permission::get();
        if ($permission->has_view) {

            $user = Users::query()->where('id_user', $id)->with('privileges')->first();
            $summary = [
                'total_patroli' => DashboardHelper::getCountPatrolByUser($user->id_user),
                'percentage_patroli' => DashboardHelper::getAveragePercentageByUser($user->id_user, $user->id_company),
                'total_abnormality' => DashboardHelper::getCountAbnormalByUser($user->id_user),
            ];
            return view('modules.users.profile', compact('user', 'permission', 'summary'));
        }
        abort(403);
    }

    public function profile(): Factory|\Illuminate\Contracts\View\View|Application
    {
        $user = Auth::user();
        $summary = [
            'total_patroli' => DashboardHelper::getCountAbnormalByUser($user->id_user),
            'percentage_patroli' => DashboardHelper::getAveragePercentageByUser($user->id_user, $user->id_company),
            'total_abnormality' => DashboardHelper::getCountAbnormalByUser($user->id_user),
        ];
        return view('modules.users.profile', compact('user', 'summary'));
    }

    public function profileEdit(Request $request): Factory|View|Application
    {
        $user = Users::query()->where('id_user', Auth::user()->id_user)->with('privileges.menu', 'userGroup')->first();
        if (!$user)
            abort(404, 'User not found');
        $userGroup = UserGroup::query()->where('status', 1)->get();
        $area = DetailPatrolConfig::where('level', '<=', 2)
            ->where('id_company', $user->id_company)
            ->whereStatus(true)
            ->orderBy('level')
            ->get();

        return view('modules.users.profile_edit', compact('user', 'userGroup', 'area'));
    }

    public function userListPatrol()
    {
        $activity = PatrolActivity::with('user', 'patrolShift', 'company', 'reportPatrol')
            ->where('id_user', Auth::user()->id_user);

        return DataTables::of($activity->get())->addIndexColumn()->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(Request $request, int $id): Factory|View|Application
    {
        $permission = Permission::get();
        if ($permission->has_edit) {
            $user = Users::query()->where('id_user', $id)->with('privileges.menu', 'userGroup')->first();
            if (!$user)
                abort(404, 'User not found');
            $userGroup = UserGroup::query()->where('status', 1)->get();
            $area = DetailPatrolConfig::where('level', '<=', 2)
                ->where('id_company', $user->id_company)
                ->whereStatus(true)
                ->orderBy('level')
                ->get();
            return view('modules.users.edit', compact('user', 'userGroup', 'area'));
        }
        abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request)
    {
        $permission = Permission::get();

        if ($permission->has_edit) {
            $request->validate([
                'id_user' => 'required',
                'name' => 'required|max:255',
                'npk' => 'required',
                'email' => 'email:rfc,dns|required',
                'phone' => 'required|numeric|digits_between:10,15',
                'status' => 'required',
                'username' => 'required',
            ]);


            $user = Users::find($request->id_user);
            $user->id_user_group = $request->userGroup;
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->npk = $request->npk;
            $user->area = $request->area;
            $user->status = $request->status;

            if ($user->save()) {
                return redirect()->route('management-user.index')
                    ->with('success', 'User Berhasil Di Update');
            }
            return redirect()->route('management-user.index')
                ->with('error', 'User Gagal Di Update');
        }

        abort(403);
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
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $deleted = Users::find($id)->deleteOrFail();
        if ($deleted)
            return \response()->json(['msg' => 'User deleted']);
        return \response()->json(['msg' => 'User failed to delete'], 502);
    }

    public function changePassword(Request $request)
    {

        if (\Auth::user()->id_user_group == UserGroup::ADMIN_COMPANY) {
            $request->validate([
                'newPassword' => 'required|confirmed',
                'id_user' => 'required',
            ]);
            $user = Users::find($request->post('id_user'));
        } else {
            $request->validate([
                'newPassword' => 'required|confirmed',
                'currentPassword' => 'required',
                'id_user' => 'required',
            ]);
            $user = Auth::user();

            if (!PasswordHash::check($request->currentPassword, $user->password)) {
                return redirect()->route('profile.edit', ['id' => $user->id_user])
                    ->with('error', 'User Gagal Di Update, Current password salah!');
            }

        }

        if ($user) {
            $user->password = Hash::make($request->post('newPassword'));
            if ($user->save()) {
                return redirect()->route('profile.edit', ['id' => $user->id_user])
                    ->with('success', 'User password telah di Update');
            }

        }
        return redirect()->route('management-user.edit', ['id' => $user->id_user])
            ->with('error', 'User Gagal Di Update');

    }

    public function activity(): Factory|\Illuminate\Contracts\View\View|Application
    {
        if (\auth()->user()->id_user_group != UserGroup::ADMINISTRATOR)
            abort(403);
        return view('modules.user_activity.index');
    }

    public function activityList()
    {
        if (\auth()->user()->id_user_group != UserGroup::ADMINISTRATOR)
            abort(403);
        $activity = DB::table('activity_log')->orderByDesc('created_at');
        return DataTables::of($activity)->addIndexColumn()->make(true);

    }
}
