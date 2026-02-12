@extends('admin.layout')
@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <h1>Edit Menu Item </h1>
        <ol class="breadcrumb">
            <li class="active">
                <a href="{{ asset('admin/menus')}}">
                    Back
                </a>
            </li>
        </ol>
    </section>


    <section class="content">


        <div class="box">

            @if( count($errors) > 0)
            <div class="box-info">
                @foreach($errors->all() as $error)

                <div class="alert alert-success" role="alert">
                    <span class="sr-only">{{ trans('labels.Error') }}:</span>
                    {{ $error }}
                </div>
                @endforeach
            </div>
            @endif

            <div class="box-header">
                <h3 class="box-title">Edit Menu</h3>
            </div>

            {!! Form::open(array('url' =>'admin/updatemenu', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

            <div class="box-body">

                <div class="row">

                    <div class="col-md-4">

                        {!! Form::hidden('id',  $result['menus']['id'], array('class'=>'form-control', 'id'=>'id')) !!}

                        <div id="languageWrap">

                            <div class="form-group">

                                <label for="name" class="control-label">Item Name</label>

                                <input type="text" name="menu_title" class="form-control" required value="{{$result['menus']['menu_title']}}" >

                            </div>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="form-group type">

                            <label for="name" class="control-label">Url Type</label>

                            <?php $arr = ['Link','Page','Category'];?>

                            <select name="type" id="url-type" class="form-control">
                                <?php

                                foreach($arr as $id => $item) :

                                    $id == $result['menus']['type'] ? $attr = 'selected' : $attr = ''; ?>
                                    
                                    <option <?=$attr?> value="<?=$id?>"><?=$item?></option>
                                    <?php

                                endforeach;?>
                                
                            </select>

                        </div>

                    </div>
<div class="col-md-4">
    <div class="form-group">
        <label for="status" class="control-label">Status</label>
        <select name="status" id="status" class="form-control">
            <option value="1" <?= $result['menus']['status'] == '1' ? 'selected' : '' ?>>Active</option>
            <option value="0" <?= $result['menus']['status'] == '0' ? 'selected' : '' ?>>Inactive</option>
        </select>
    </div>
</div>

                    <div class="col-md-4 link url mt-3" <?=$result['menus']['type'] == 0 ? 'style="display:block;"' : ''?>>

                        <div class="form-group external_link">

                            <label for="name" class="control-label">Url</label>

                            <input value="{{str_replace('page/','',$result['menus']['link'] )}}" name="external_link" class="form-control menu">

                        </div>

                    </div>
                    
                    <div class="col-md-4 link page mt-3" <?=$result['menus']['type'] == 1 ? 'style="display:block;"' : ''?>>

                        <div class="form-group external_link">

                            <label for="name" class="control-label">Page</label>

                            <select name="link" class="form-control">

                                <?php

                                foreach( $result['pages'] as $page ) :

                                    $attr = asset($page['slug']) == $result['menus']['link'] ? 'selected' : ''; ?>

                                    <option <?=$attr?> value="<?=asset($page['slug'])?>"><?=$page['page_title']?></option>

                                    <?php

                                endforeach;?>

                            </select>

                        </div>

                    </div>

                    <div class="col-md-4 link category mt-3" <?=$result['menus']['type'] == 2 ? 'style="display:block;"' : ''?>>

                        <div class="form-group external_link">

                            <label for="name" class="control-label">Category</label>

                            <select name="category" class="form-control">

                                <?php

                                foreach( $result['categories'] as $cat ) :

                                    $attr = $cat['category_ID'] == $result['menus']['page_id'] ? 'selected' : ''; ?>

                                    <option <?=$attr?> value="<?=$cat['category_ID']?>"><?=$cat['category_title']?></option>

                                    <?php

                                endforeach;?>

                            </select>

                        </div>

                    </div>

                    <div class="col-md-4 mt-3">

                        <div class="form-group">

                            <label for="type" class="control-label">Menu</label>

                            <select name="menu" class="form-control">

                                <?php

                                $marr = [

                                    'main'  => 'Main',

                                    'get-to-know-us' => 'About Us',

                                    'quick-links' => 'Help & Support',

                                    'our-legal'  => 'Legal & Policies',

                                ];

                                foreach($marr as $key => $menu) : 

                                    $attr = $key == $result['menus']['menu'] ? 'selected' : ''; ?>

                                    <option <?=$attr?> value="<?=$key?>"><?=$menu?></option>

                                <?php endforeach;?>

                            </select>

                        </div>

                    </div>

                    <div class="col-md-4 mt-3">

                        <div class="form-group">

                            <label for="type" class="control-label">Language</label>

                            <select name="lang" id="change_lang" data-url="<?=asset('admin/menu/change_lang')?>" data-id="<?=$result['menus']['id']?>" class="form-control">                        

                                <option value="1">English</option>
                                <option value="2">Arabic</option>

                            </select>

                        </div>

                    </div>

                </div>

            </div>

            <div class="box-footer text-center">
                <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
            </div>


            {!! Form::close() !!}
        </div>

    </section>
</div>

<style>.link{display: none;}</style>
@endsection
