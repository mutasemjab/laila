@extends('layouts.admin')
@section('title')
    {{ __('messages.Edit') }} {{ __('messages.users') }}
@endsection



@section('contentheaderlink')
    <a href="{{ route('users.index') }}"> {{ __('messages.users') }} </a>
@endsection

@section('contentheaderactive')
    {{ __('messages.Edit') }}
@endsection


@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center">{{ __('messages.Edit') }} {{ __('messages.users') }}</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form action="{{ route('users.update', $data['id']) }}" method="POST" enctype='multipart/form-data'>
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.Title') }}</label>
                            <input name="title" id="title" class="form-control" value="{{ old('title', $data['title']) }}">
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.First_Name') }}</label>
                            <input name="first_name" id="first_name" class="form-control" value="{{ old('first_name', $data['first_name']) }}">
                            @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.Second_Name') }}</label>
                            <input name="second_name" id="second_name" class="form-control" value="{{ old('second_name', $data['second_name']) }}">
                            @error('second_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.Last_Name') }}</label>
                            <input name="last_name" id="last_name" class="form-control" value="{{ old('last_name', $data['last_name']) }}">
                            @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.Company') }}</label>
                            <input name="company" id="company" class="form-control" value="{{ old('company', $data['company']) }}">
                            @error('company')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.Country') }}</label>
                            <input name="country" id="country" class="form-control" value="{{ old('country', $data['country']) }}">
                            @error('country')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.Email') }}</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $data['email']) }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.Phone') }}</label>
                            <input name="phone" id="phone" class="form-control" value="{{ old('phone', $data['phone']) }}">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.Gender') }}</label>
                            <select name="gender" id="gender" class="form-control">
                                <option value="">{{ __('messages.Select') }}</option>
                                <option @if ($data->gender == 1) selected="selected" @endif value="1">{{ __('messages.Male') }}</option>
                                <option @if ($data->gender == 2) selected="selected" @endif value="2">{{ __('messages.Female') }}</option>
                            </select>
                            @error('gender')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.Category') }}</label>
                            <select name="category" id="category" class="form-control">
                                <option value="">{{ __('messages.Select') }}</option>
                                <option @if ($data->category == 1) selected="selected" @endif value="1">{{ __('messages.Speaker') }}</option>
                                <option @if ($data->category == 2) selected="selected" @endif value="2">{{ __('messages.Participant') }}</option>
                                <option @if ($data->category == 3) selected="selected" @endif value="3">{{ __('messages.Exhibition') }}</option>
                            </select>
                            @error('category')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('messages.Activate') }}</label>
                            <select name="activate" id="activate" class="form-control">
                                <option value="">{{ __('messages.Select') }}</option>
                                <option @if ($data->activate == 1) selected="selected" @endif value="1">{{ __('messages.Activate') }}</option>
                                <option @if ($data->activate == 2) selected="selected" @endif value="2">{{ __('messages.Deactivate') }}</option>
                            </select>
                            @error('activate')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group text-center">
                            <button id="do_add_item_cardd" type="submit" class="btn btn-primary btn-sm">{{ __('messages.Update') }}</button>
                            <a href="{{ route('users.index') }}" class="btn btn-sm btn-danger">{{ __('messages.Cancel') }}</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection



