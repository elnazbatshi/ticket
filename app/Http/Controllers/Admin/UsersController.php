<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Role;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all();

        return view('admin.users.index', compact('users'));
    }
    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');
        $categories = Category::all();
        return view('admin.users.create', compact('roles', 'categories'));
    }

    public function store(StoreUserRequest $request)
    {
//    dd($request->input('categories_agent', []),$request->input('roles', []));


        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));
        dd($request->input('categories_agent'));
        if ($request->input('categories_agent')) {
            $user->agent_category()->sync($request->input('categories_agent', []));
       }
        if ($request->input('categories_customer')) {

            $user->customer_category()->sync($request->input('categories_customer', []));
        }

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');
//        $categories = $user->load('agent_category');
        $categories = Category::all();

        $user->loadMissing('roles','agent_category','customer_category');


        return view('admin.users.edit', compact('roles', 'user','categories'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        $user->agent_category()->sync($request->input('categories_agent', []));
        $user->customer_category()->sync($request->input('categories_customer', []));

        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
