@extends('admin.layout')



@section('content')



<div class="content-wrapper">

    <section class="content-header">

        <h1>Home Page Content</h1>

    </section>

    <section class="content">

        <div class="row">

            <div class="col-md-12">

                <div class="box">

                    @if( count($errors) > 0)

                    @foreach($errors->all() as $error)

                    <div class="alert alert-success" role="alert">

                        <span class="icon fa fa-check" aria-hidden="true"></span>

                        {{ $error }}

                    </div>

                    @endforeach

                    @endif

                    {!! Form::open(array('url' =>'admin/updateSetting', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}

                    <div class="box-body">

                        <div class="row mb-3">

                            <div class="col-md-4">

                                <label for="change_lang" class="control-label mb-1">Langugage</label>

                                <select name="lang" class="form-control" id="change_lang" data-url="<?=asset('admin/change_lang')?>">
                                    <option value="1">English</option>
                                    <option value="2">Arabic</option>
                                </select>

                            </div>

                        </div>

                        <div id="languageWrap">

                            @include('admin.settings.fields',['result' => $result])

                        </div>

                    </div>

                    <div class="box-footer text-center">

                        <button type="submit" class="btn btn-primary">Submit</button>

                        <a href="{{ URL::to('admin/dashboard/')}}" type="button" class="btn btn-primary">Back</a>

                    </div>

                </div>

            </div>

        </section>



    </div>



    @endsection