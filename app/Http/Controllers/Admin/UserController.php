<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserDataTable $userDataTable)
    {
        return $userDataTable->render('admin.users.index',[$userDataTable]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $roles = Role::all();
        return view('admin.users.create')
            ->with('roles', $roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUserRequest  $request
     * @return RedirectResponse
     */
    public function store(StoreUserRequest  $request): RedirectResponse
    {
        $imageName = time() . '.' . $request->avatar->extension();

        try {
            $avatar = 'images/user_images/' . $imageName;
            $user = User::create($request->safe()->except('avatar'), ['avatar' => $avatar]);

            if ($request->has('roles')) {
                $roles = Role::whereIn('id', $request->roles)->get();
                foreach ($roles as $role) {
                    $user->assignRole($role);
                }
            }

            try {
                $request->avatar->move(public_path('images/user_images'), $imageName);
            } catch (Exception $ex) {
                return back()->withError('Picture uploadation failed, please try again');
            }

            if ($user->save()) {
                return redirect()->route('user.index');
            } else {
                return back()->withError('Something went wrong !');
            }
        } catch (Exception $ex) {
            return back()->withError('Something went wrong !');
        }
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
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        $roles = Role::all();
        return view('admin.users.edit')
            ->with(
                ['user' => $user, 'roles' => $roles]
            );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $validatedUser = $request->validated();

        if (isset($validatedUser['avatar'])) {
            try {
                $imageName = time() . '.' . $request->avatar->extension();
                $user->update(['avatar' => 'images/user_images/' . $imageName]);
                $request->avatar->move(public_path('images/user_images'), $imageName);
            } catch (Exception $ex) {
                return back()->withError('Picture uploadation failed, please try again');
            }
        }

        try {
            $user->update([
                'name' => $validatedUser['name'],
                'mobile_number' => $validatedUser['mobile_number']
            ]);

            if ($request->has('roles')) {
                $roles = Role::whereIn('id', $request->roles)->get();
                $user->syncRoles($roles);
            } else {
                $user->syncRoles();
            }

            if ($user->save()) {
                return redirect()->route('user.index');
            } else {
                return back()->withError('Something went wrong !');
            }
        } catch (Exception $ex) {
            return back()->withError('Something went wrong !');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        try {
            $user->syncRoles();
            $user->delete();

            return redirect()->back()->withSuccess('User successfully deleted');
        } catch (Exception $ex) {
            return back()->withError('User not deleted');
        }
    }

}
