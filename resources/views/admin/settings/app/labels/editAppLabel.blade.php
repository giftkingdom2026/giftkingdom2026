@extends('admin.layout')
@section('content')
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> Edit Label </h1>
    <ol class="breadcrumb">
      <li><a href="<?= URL::to('admin/dashboard/this_month') ?>"><i class="fa fa-dashboard"></i> <?= trans('labels.breadcrumb_dashboard') ?></a></li>
      <li><a href="<?= URL::to('admin/listingAppLabels')?>"><i class="fa fa-bars"></i> List All Labels</a></li>
      <li class="active">Edit Label</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Edit labels </h3>
            
            <?php

            if (count($errors) > 0) : 

              if($errors->any()) : ?>

                <div class="alert alert-danger alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <?=$errors->first()?>
                </div>

              <?php endif;

            endif;

            if(session()->has('message')) : ?>

              <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?= session()->get('message') ?>
              </div>

            <?php endif;?>

          </div>

          <div class="box-body">

            {!! Form::open(array('url' =>'admin/updateAppLabel', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
            {!! Form::hidden('id',  $result['labels_value'][0]->label_id , array('class'=>'form-control', 'id'=>'id')) !!}

            <?php $i = 0; $j=0;

            foreach($result['languages'] as $language) :

              $labelValue = $result['labels_value']->firstWhere('language_id', $language->languages_id);

              if($labelValue)  : ?>

                <input type="hidden" name="label_value_id_<?= $language->languages_id ?>" value="<?= $labelValue->label_value_id ?>">

              <?php endif;?>

              <div class="form-group mt-3">
                <label class="col-sm-2 col-md-3 control-label">Label Value (<?= $language->name ?>)</label>
                <div class="col-sm-10 col-md-4">
                  <input type="text" name="label_value_<?= $language->languages_id ?>" class="form-control field-validate" 
                  value="<?= $labelValue ? $labelValue->label_value : '' ?>">
                </div>
              </div>

            <?php endforeach;?>

            {!! Form::close() !!}

          </div>

          <div class="box-footer text-center">
            <button type="submit" class="btn btn-primary"><?= trans('labels.Submit') ?></button>
            <a href="<?= URL::to('admin/listingAppLabels')?>" type="button" class="btn btn-default"><?= trans('labels.back') ?></a>
          </div>

        </div>
      </div>
    </div>
  </section>
</div>

@endsection 