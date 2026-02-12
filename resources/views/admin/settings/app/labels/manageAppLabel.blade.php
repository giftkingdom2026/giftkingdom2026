@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> <?= trans('labels.AppLabels') ?> <small><?= trans('labels.ManageLabel') ?>...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="<?= URL::to('admin/dashboard/this_month') ?>"><i class="fa fa-dashboard"></i> <?= trans('labels.breadcrumb_dashboard') ?></a></li>
            <li class="active"><?= trans('labels.ManageLabel') ?></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">

                    <div class="box-header">

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
                            </div><br>

                        <?php endif;?>

                    </div>

                    <div class="box-body">

                        <div id="main">
                            <div class="accordion" id="faqs">
                                <div class="card">
                                    @foreach ($result['labels'] as $key => $data)
                                    <div class="accordion" id="accordion<?=$key?>">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading<?=$key?>">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?=$key?>" aria-expanded="false" aria-controls="collapse<?=$key?>">
                                                    Label Step <?=$key + 1?>
                                                </button>
                                            </h2>
                                            <div id="collapse<?=$key?>" class="accordion-collapse collapse" aria-labelledby="heading<?=$key?>" data-bs-parent="#accordion<?=$key?>">
                                                <div class="accordion-body">
                                                    {!! Form::open(['url' => 'admin/updateAppLabel', 'name' => 'form', 'method' => 'post', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
                                                    @foreach ($data as $labels_data)
                                                    <?php $labels_data1 = $labels_data->values->toArray(); ?>
                                                    <h4><strong><?= trans('labels.LabelKey') ?>:</strong> <?= $labels_data->label_name ?></h4>
                                                    <?php $j = 0; ?>
                                                    @foreach($result['languages'] as $keys => $languages)
                                                    <input type="hidden" name="label_id_<?=$labels_data->label_id?>" value="<?= $labels_data->label_id ?>">
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label"><?= trans('labels.LabelValue') ?> (<?= $languages->name ?>)</label>
                                                        <input type="text" name="label_value_<?=$languages->languages_id?>_<?=$labels_data->label_id?>" class="form-control" value="<?= !empty($labels_data1[$j]->language_id) && $languages->languages_id == $labels_data1[$j]->language_id ? $labels_data1[$j]->label_value : '' ?>">
                                                        <div class="form-text"><?= trans('labels.LabelValue') ?> (<?= $languages->name ?>).</div>
                                                    </div>
                                                    <?php $j++; ?>
                                                    @endforeach
                                                    @endforeach
                                                    <div class="d-flex justify-content-between">
                                                        <a href="<?= URL::to('admin/dashboard') ?>" class="btn btn-secondary"><?= trans('labels.back') ?></a>
                                                        <button type="submit" class="btn btn-primary"><?= trans('labels.Submit') ?></button>
                                                    </div>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>
</section>
</div>
@endsection