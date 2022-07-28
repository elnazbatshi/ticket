@extends('layouts.admin')
@section('content')
    {{--{{dd($categories)}}--}}
    {{--@dd($user->toArray())--}}
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.user.title_singular') }}
        </div>

        <div class="card-body">
            <form action="{{ route("admin.users.update", [$user->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="name">{{ trans('cruds.user.fields.name') }}*</label>
                    <input type="text" id="name" name="name" class="form-control"
                           value="{{ old('name', isset($user) ? $user->name : '') }}" required>
                    @if($errors->has('name'))
                        <em class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.user.fields.name_helper') }}
                    </p>
                </div>
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">{{ trans('cruds.user.fields.email') }}*</label>
                    <input type="email" id="email" name="email" class="form-control"
                           value="{{ old('email', isset($user) ? $user->email : '') }}" required>
                    @if($errors->has('email'))
                        <em class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.user.fields.email_helper') }}
                    </p>
                </div>
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="password">{{ trans('cruds.user.fields.password') }}</label>
                    <input type="password" id="password" name="password" class="form-control">
                    @if($errors->has('password'))
                        <em class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.user.fields.password_helper') }}
                    </p>
                </div>
                <div class="form-group {{ $errors->has('roles') ? 'has-error' : '' }}">
                    <label for="roles">{{ trans('cruds.user.fields.roles') }}*
                        <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
                    <select name="roles[]" id="roles" class="form-control select2" multiple="multiple" required>
                        @foreach($roles as $id => $roles)
                            <option
                                value="{{ $id }}" {{ (in_array($id, old('roles', [])) || isset($user) && $user->roles->contains($id)) ? 'selected' : '' }}>{{ $roles }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('roles'))
                        <em class="invalid-feedback">
                            {{ $errors->first('roles') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.user.fields.roles_helper') }}
                    </p>
                </div>

                <div id="projectsAgent" class="form-group {{empty($user->agent_category->toArray())?'d-none':''}}">
                    <label for="permissions">پروژه مرتبط با اپراتور
                        <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
                    <select name="categories_agent[]" id="categories_agent" class="form-control select2"
                            multiple="multiple">
                        @foreach($categories as $category)
                            <option
                                value="{{ $category->id }}" {{ (in_array($category->id, old('categories_agent',[])) || isset($user) && $user->agent_category->contains($category->id)) ? 'selected' : '' }}>{{ $category->name }} </option>
                        @endforeach
                    </select>
                    @if($errors->has('agents'))
                        <em class="invalid-feedback">
                            {{ $errors->first('agents') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.role.fields.permissions_helper') }}
                    </p>
                </div>

                <div id="projectsCustomer" class="form-group   {{empty($user->customer_category->toArray())?'d-none':''}}">
                    <label for="permissions">پروژه مرتبط با مشتری
                        <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
                    <select name="categories_customer[]" id="categories_customer" class="form-control select2"
                            multiple="multiple">
                        @foreach($categories as $category)
                            <option
                                value="{{ $category->id }}" {{ (in_array($category->id, old('categories_customer',[])) || isset($user) && $user->customer_category->contains($category->id)) ? 'selected' : '' }}>{{ $category->name }} </option>
                        @endforeach
                    </select>
                    @if($errors->has('agents'))
                        <em class="invalid-feedback">
                            {{ $errors->first('agents') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.role.fields.permissions_helper') }}
                    </p>
                </div>


                <div>
                    <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
                </div>
            </form>


        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).on("change", "#roles", function () {
            // $roles=$('#roles').val();
            var roles = $('#roles').val();
            console.log(roles, $.inArray('3', roles));
            if ($.inArray('2', roles) !== -1) {
                $("#projectsAgent").removeClass("d-none");
                $("#projectsAgent").addClass("d-block");
            } else {
                $("#projectsAgent").addClass("d-none");
                $("#projectsAgent").removeClass("d-block");
            }

            if ($.inArray('3', roles) !== -1) {
                $("#projectsCustomer").removeClass("d-none");
                $("#projectsCustomer").addClass("d-block");
            } else {
                $("#projectsCustomer").addClass("d-none");
                $("#projectsCustomer").removeClass("d-block");
            }


        })
    </script>
@endsection
