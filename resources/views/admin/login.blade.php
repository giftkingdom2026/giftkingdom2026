@extends('admin.layoutLlogin')
@section('content')

<?php
use App\Models\Core\Setting;

$result['commonContent'] = Setting::commonContent();?>


<div class="login-box">
  <div class="login-logo">

   <img src="{{asset($result['commonContent']['setting']['footer-image']['path'])}}">

   <h4 class="mb-4"><b> {{ trans('labels.welcome_message') }} </b>{{ trans('labels.welcome_message_to') }}</h4>
 </div>
 
 <div class="login-box-body">

  @if( count($errors) > 0)
  @foreach($errors->all() as $error)
  <div class="alert alert-danger" role="alert">
    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
    <span class="sr-only">{{ trans('labels.Error') }}:</span>
    {{ $error }}
  </div>
  @endforeach
  @endif

  @if(Session::has('loginError'))
  <div class="alert alert-danger" role="alert">
    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
    <span class="sr-only">{{ trans('labels.Error') }}:</span>
    {!! session('loginError') !!}
  </div>
  @endif

  {!! Form::open(array('url' =>'admin/checkLogin', 'method'=>'post', 'class'=>'form-validate')) !!}
  <div class="row">
    <div class="col-md-12">
      <div class="form-group has-feedback mb-3">
        <label>Email:</label>
        {!! Form::email('email', '', array('class'=>'form-control email-validate', 'id'=>'email')) !!}
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group has-feedback">
        <label>Password:</label>
        <input type="password" name='password' class='form-control field-validate' value="">
      </div>
    </div>
  </div>
  
  
  <img src="">
  <div class="row">

    <!-- /.col -->
    <div class="col-xs-4">
      {!! Form::submit(trans('labels.login'), array('id'=>'login', 'class'=>'btn btn-primary btn-block btn-flat' )) !!}
    </div>
    <!-- /.col -->
  </div>
  {!! Form::close() !!}

</div>

<!-- /.login-box-body -->
</div>
@endsection
