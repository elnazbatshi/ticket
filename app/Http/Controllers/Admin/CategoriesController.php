<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCategoryRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Role;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoriesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::with(['customers','agents'])->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        abort_if(Gate::denies('category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $agents=User::whereHas('roles', function($q){
            $q->where('title', '=', 'Agent');
        })->get();
        $customers=User::whereHas('roles', function($q){
            $q->where('title', '=', 'Customer');
        })->get();

        return view('admin.categories.create',compact('agents','customers'));
    }

    public function store(StoreCategoryRequest $request)
    {

        $category = Category::create($request->all());
       $category->customers()->attach($request->input('customers', []));
       $category->agents()->attach($request->input('agents', []));

        return redirect()->route('admin.categories.index');
    }

    public function edit(Category $category)
    {
        abort_if(Gate::denies('category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $agents=User::whereHas('roles', function($q){
            $q->where('title', '=', 'Agent');
        })->get();
        $customers=User::whereHas('roles', function($q){
            $q->where('title', '=', 'Customer');
        })->get();
        return view('admin.categories.edit', compact('category','customers','agents'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->all());
        $category->customers()->sync($request->input('customers', []));
        $category->agents()->sync($request->input('agents', []));
        return redirect()->route('admin.categories.index');
    }

    public function show(Category $category)
    {
        abort_if(Gate::denies('category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.categories.show', compact('category'));
    }

    public function destroy(Category $category,Request $request)
    {

        abort_if(Gate::denies('category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $category->customers()->detach($request->ids);
        $category->agents()->detach($request->ids);
        $category->delete();
        return back();
    }

    public function massDestroy(MassDestroyCategoryRequest $request)
    {

        $category=Category::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
