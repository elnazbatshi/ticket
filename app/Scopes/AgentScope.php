<?php

namespace App\Scopes;

use App\Category;
use App\User;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class AgentScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {

        $user = auth()->user();
        $userRoles = $user->roles->pluck('title')->toArray();
        $relationType = null;
        if (in_array('Customer', $userRoles)) {
            $relationType = 'customers';
        } elseif (in_array('Agent', $userRoles)) {
            $relationType = 'agents';
        }
        $builder->when(auth()->check() && auth()->user()->roles()->count() == 0, function ($query) {
            $query->where('author_id', auth()->id());
        });

         $category_id = Category::when($relationType, function ($query) use ($relationType, $user) {
            $query->whereHas($relationType, function ($q) use ($user) {
                $q->where('id', $user->id);
            });
        })->get()->pluck('id')->toArray();


        if (in_array('Customer', $userRoles) || in_array('Agent', $userRoles)) {
            $builder->whereIn('category_id', $category_id);
        }
    }
}



/*$user = auth()->user();
$allUser = User::with('roles')->find(auth()->user()->id)->roles->pluck('title')->toArray();
$adminUser = in_array('Admin', $allUser);
//        $customerUser = in_array('Customer', $user);
$agentUser = in_array('Agent', $allUser);
if (!$adminUser) {
    if ($agentUser) {
        $category_id = Category::whereHas('agents', function ($q) {
            $q->where('id', '=', auth()->user()->id);
        })->get()->pluck('id');
    } else {
        $category_id = Category::whereHas('customers', function ($q) {
            $q->where('id', '=', auth()->user()->id);
        })->get()->pluck('id');
    }
}

if (auth()->check() && request()->is('admin/*') && $user->roles->contains(2) && $user->roles->contains(3)) {
    $builder->where('category_id', [$category_id]);
}*/
