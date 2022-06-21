@extends('dashboard.layouts.layout')

@section('body')
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{__('words.dashboard')}}</li>
        <li class="breadcrumb-item"><a href="#">{{ __('words.users') }}</a>
        </li>
        <li class="breadcrumb-item active">{{ $user->name }}</li>

        <!-- Breadcrumb Menu-->
        <li class="breadcrumb-menu">
            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                <a class="btn btn-secondary" href="#"><i class="icon-speech"></i></a>
                <a class="btn btn-secondary" href="./"><i class="icon-graph"></i> &nbsp;{{ __('words.users') }}</a>
                <a class="btn btn-secondary" href="#"><i class="icon-settings"></i> &nbsp;{{ $user->name }}</a>
            </div>
        </li>
    </ol>


    <div class="container-fluid">

        <div class="animated fadeIn">
            <form action="{{ Route('dashboard.users.update', $user) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <strong>{{ __('words.users') }}</strong>
                        </div>
                        <div class="card-block">




                            <div class="form-group col-md-12">
                                <label>{{ __('words.name') }}</label>
                                <input type="text" name="name" class="form-control" placeholder="{{ __('words.name') }}"
                                    value="{{ $user->name }}">
                            </div>
                            <div class="form-group col-md-12">
                                <label>{{ __('words.email') }}</label>
                                <input type="text" name="email" class="form-control"
                                    placeholder="{{ __('words.email') }}" value="{{ $user->email }}">
                            </div>

                            @can('viewAny', $user)
                                
                          
                            <div class="form-group col-md-12">
                                <label>{{ __('words.status') }}</label>
                                <select name="status" id="" class="form-control">
                                  
                                    <option value="admin" @if ($user->status == 'admin')
                                        selected
                                    @endif>Admin</option>
                                    <option value="writer" @if ($user->status == 'Writer')
                                        selected
                                    @endif>Writer</option>
                                    <option value="" @if ($user->status == '')
                                        selected
                                    @endif>غير مفعل </option>
                                </select>
                               
                            </div>
                            @endcan
                        </div>




                        <div class="card-footer">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i>
                                Submit</button>
                            <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i>
                                Reset</button>
                        </div>



                    </div>
            </form>
        </div>
    </div>
@endsection
