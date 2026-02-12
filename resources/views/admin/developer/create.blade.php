@extends('admin.layout')







@section('content')



<div class="content-wrapper">
    <section class="content-header">
        <h1>Create Template</h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::previous() }}">Back</a></li>
        </ol>
    </section>


    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Create Template</h3>
            </div>
            <div class="box-body">
                <div class="row">

                    <div class="col-md-3">
                        <div class="reset_repetative btn-primary d-none btn" id="reset">Reset Repetative</div>
                        <div class="fields">
                            <ul class="field-list p-0" data-count="0">

                                <li type="section">SECTION</li>

                                <li type="text">TEXT</li>

                                <li type="editor">TEXT EDITOR</li>

                                <li type="image">IMAGE</li>

                                <li type="video">VIDEO</li>

                                <li type="repetitive">REPETATIVE CONTENT</li>

                                <li type="file">FILE</li>

                            </ul>
                        </div>
                    </div>

                    

                    <div class="col-md-9">
                        <div class="fields-view">
                        </div>
                        <div class="d-none fields-array">
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer text-center">
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="templatetype" placeholder="Template Type" value="page">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="templatename" placeholder="Template Name">
                    </div>

                    

                    <div class="col-md-1">
                        <button class="btn d-block btn-primary" id="savetemplate">Save</button>

                        

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection



<style>
    .section-box {padding: 0;margin-bottom: 1rem;border: solid 1px #40004c;border-radius: 10px;}



    .section-box .section-title {padding: 1rem;font-size: 20px;color: #40004c;background: #0000001a;position:relative;display:flex;align-items:center;}



    .section-box form {padding: 1rem;transition: ease 0.5s;}



    .collapsed{height: 0 !important;padding: 0 !important;margin: 0 !important;overflow: hidden !important;}



    .sub{margin-left: 1rem;}



    a.delete {position: absolute;right:10px;padding: 0.5rem; cursor: pointer;background: #40004c;}



    .delete svg{width: 10px;height: 10px;}



    .delete svg path{fill:#ffff }


    #reset {position: absolute;top: 5px;right: 0;}

</style>