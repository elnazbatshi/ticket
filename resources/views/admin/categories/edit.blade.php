@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.category.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.categories.update", [$category->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('cruds.category.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($category) ? $category->name : '') }}" required>
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.category.fields.name_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('color') ? 'has-error' : '' }}">
                <label for="color">{{ trans('cruds.category.fields.color') }}</label>
                <input type="text" id="color" name="color" class="form-control colorpicker" value="{{ old('color', isset($category) ? $category->color : '') }}">
                @if($errors->has('color'))
                    <em class="invalid-feedback">
                        {{ $errors->first('color') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.category.fields.color_helper') }}
                </p>
            </div>


            <div class="form-group {{ $errors->has('customers') ? 'has-error' : '' }}">
                <label for="permissions">{{ trans('cruds.category.fields.customer') }}
                    <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
                <select name="customers[]" id="customers" class="form-control select2" multiple="multiple" >

                    @foreach($customers as $id => $user)

                        <option value="{{ $user->id }}" {{ (in_array($id, old('$customers', [])) || isset($customers) && $category->customers->contains('id',$user->id)) ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
                @if($errors->has('customers'))
                     <em class="invalid-feedback">
                        {{ $errors->first('customers') }}
                     </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.role.fields.permissions_helper') }}
                </p>
            </div>


            <div class="form-group {{ $errors->has('agents') ? 'has-error' : '' }}">
                <label for="permissions">{{ trans('cruds.category.fields.agent') }}
                    <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
                <select name="agents[]" id="agents" class="form-control select2" multiple="multiple" >
                    @foreach($agents as $id => $user)
                        <option value="{{ $user->id }}" {{ (in_array($id, old('agents', [])) || isset($agents) && $category->agents->contains($user->id)) ? 'selected' : '' }}>{{ $user->name }}</option>
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

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.min.css" rel="stylesheet">
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/js/bootstrap-colorpicker.min.js"></script>
<script>
    $('.colorpicker').colorpicker();
</script>
@endsection
