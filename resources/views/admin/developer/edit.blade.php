@extends('admin.layout')







@section('content')



<?php

$sections = unserialize($template['data']);

$svg = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" version="1.1" id="Capa_1" width="800px" height="800px" viewBox="0 0 94.926 94.926" xml:space="preserve"><g>

<path d="M55.931,47.463L94.306,9.09c0.826-0.827,0.826-2.167,0-2.994L88.833,0.62C88.436,0.224,87.896,0,87.335,0   c-0.562,0-1.101,0.224-1.498,0.62L47.463,38.994L9.089,0.62c-0.795-0.795-2.202-0.794-2.995,0L0.622,6.096   c-0.827,0.827-0.827,2.167,0,2.994l38.374,38.373L0.622,85.836c-0.827,0.827-0.827,2.167,0,2.994l5.473,5.476   c0.397,0.396,0.936,0.62,1.498,0.62s1.1-0.224,1.497-0.62l38.374-38.374l38.374,38.374c0.397,0.396,0.937,0.62,1.498,0.62   s1.101-0.224,1.498-0.62l5.473-5.476c0.826-0.827,0.826-2.167,0-2.994L55.931,47.463z"/></g></svg>'; ?>

<div class="content-wrapper">

    <section class="content-header">

        <h1>Edit Template</h1>

        <ol class="breadcrumb">

            <li><a href="{{ URL::previous() }}">Back</a></li>

        </ol>

    </section>



    <section class="content">

        <div class="box">

            <div class="box-header">

                <h3 class="box-title">Edit Template</h3>

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



                            <?php



                            foreach ($sections as $sec) :   ?>

                                <div draggable="true" class="section-field-view deletable">

                                    <div class="container">

                                        <div class="section-box">

                                            <div class="section-title">

                                                <?= $sec['title'] ?>

                                                <a href="javascript:;" class="delete">

                                                    <?= $svg ?>

                                                </a>

                                            </div>

                                            <form data-id="#<?= $sec['key'] ?>" class="collapsed">

                                                <div class="row">

                                                    <div class="col-md-6">

                                                        <div class="form-group">

                                                            <input type="text" name="title" class="title form-control" placeholder="Title" value="<?= $sec['title'] ?>">

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="form-group">

                                                            <input type="text" name="key" class="key form-control" placeholder="Key" value="<?= $sec['key'] ?>">

                                                        </div>

                                                    </div>

                                                </div>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                                <?php



                                $fields = $sec['data'];



                                foreach ($fields as $field) :



                                    switch ($field['field-type']) {



                                        case 'text': ?>

                                            <div draggable="true" class="text-field-view deletable">

                                                <div class="container">

                                                    <div class="section-box sub">

                                                        <div class="section-title">

                                                            <?= $field['title'] ?>

                                                            <a href="javascript:;" class="delete">

                                                                <?= $svg ?>

                                                            </a>

                                                        </div>

                                                        <form data-id="#<?= $field['key'] ?>" class="collapsed">

                                                            <div class="row">

                                                                <div class="col-md-4">

                                                                    <div class="form-group">

                                                                        <input type="text" name="title" class="title form-control" placeholder="Title" value="<?= $field['title'] ?>">

                                                                    </div>

                                                                </div>

                                                                <div class="col-md-4">

                                                                    <div class="form-group">

                                                                        <input type="text" name="key" class="key form-control" placeholder="Key" value="<?= $field['key'] ?>">

                                                                    </div>

                                                                </div>

                                                                <div class="col-md-4">

                                                                    <div class="form-group">

                                                                        <input type="text" name="column_class" class="column_class form-control" placeholder="Column" value="<?= $field['column_class'] ?>">

                                                                    </div>

                                                                </div>
                                                                <div class="col-md-4 mt-3">
                                                                    <div class="form-group">
                                                                        <select name="is_required" class="is_required form-control">
                                                                            <option value="0" <?= ($field['is_required'] ?? 0) == 0 ? 'selected' : '' ?>>
                                                                                Not Required
                                                                            </option>
                                                                            <option value="1" <?= ($field['is_required'] ?? 0) == 1 ? 'selected' : '' ?>>
                                                                                Required
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </form>

                                                    </div>

                                                </div>

                                            </div>

                                        <?php



                                            break;



                                        case 'image': ?>

                                            <div draggable="true" class="text-field-view deletable">

                                                <div class="container">

                                                    <div class="section-box sub">

                                                        <div class="section-title">

                                                            <?= $field['title'] ?>

                                                            <a href="javascript:;" class="delete">

                                                                <?= $svg ?>

                                                            </a>

                                                        </div>

                                                        <form data-id="#<?= $field['key'] ?>" class="collapsed">

                                                            <div class="row">

                                                                <div class="col-md-6">

                                                                    <div class="form-group">

                                                                        <input type="text" name="title" class="title form-control" placeholder="Title" value="<?= $field['title'] ?>">

                                                                    </div>

                                                                </div>

                                                                <div class="col-md-6">

                                                                    <div class="form-group">

                                                                        <input type="text" name="key" class="key form-control" placeholder="Key" value="<?= $field['key'] ?>">

                                                                    </div>

                                                                </div>

                                                                <div class="col-md-4 mt-3">

                                                                    <div class="form-group">

                                                                        <input type="text" name="column_class" class="column_class form-control" placeholder="Column" value="<?= $field['column_class'] ?>">

                                                                    </div>

                                                                </div>

                                                                <div class="col-md-4 mt-3">

                                                                    <div class="form-group">

                                                                        <input type="text" name="height" class="height form-control" placeholder="Height" value="<?= $field['height'] ?>">

                                                                    </div>

                                                                </div>

                                                                <div class="col-md-4 mt-3">

                                                                    <div class="form-group">

                                                                        <input type="text" name="uploadtyp" class="uploadtyp form-control" placeholder="Type" value="<?= $field['uploadtyp'] ?>">

                                                                    </div>

                                                                </div>
                                                                <div class="col-md-4 mt-3">
                                                                    <div class="form-group">
                                                                        <select name="is_required" class="is_required form-control">
                                                                            <option value="0" <?= ($field['is_required'] ?? 0) == 0 ? 'selected' : '' ?>>
                                                                                Not Required
                                                                            </option>
                                                                            <option value="1" <?= ($field['is_required'] ?? 0) == 1 ? 'selected' : '' ?>>
                                                                                Required
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </form>

                                                    </div>

                                                </div>

                                            </div>



                                        <?php



                                            break;



                                        case 'video': ?>

                                            <div draggable="true" class="text-field-view deletable">

                                                <div class="container">

                                                    <div class="section-box sub">

                                                        <div class="section-title">

                                                            <?= $field['title'] ?>

                                                            <a href="javascript:;" class="delete">

                                                                <?= $svg ?>

                                                            </a>

                                                        </div>

                                                        <form data-id="#<?= $field['key'] ?>" class="collapsed">

                                                            <div class="row">

                                                                <div class="col-md-4">

                                                                    <div class="form-group">

                                                                        <input type="text" name="title" class="title form-control" placeholder="Title" value="<?= $field['title'] ?>">

                                                                    </div>

                                                                </div>

                                                                <div class="col-md-4">

                                                                    <div class="form-group">

                                                                        <input type="text" name="key" class="key form-control" placeholder="Key" value="<?= $field['key'] ?>">

                                                                    </div>

                                                                </div>

                                                                <div class="col-md-4">

                                                                    <div class="form-group">

                                                                        <input type="text" name="column_class" class="column_class form-control" placeholder="Column" value="<?= $field['column_class'] ?>">

                                                                    </div>

                                                                </div>
                                                                <div class="col-md-4 mt-3">
                                                                    <div class="form-group">
                                                                        <select name="is_required" class="is_required form-control">
                                                                            <option value="0" <?= ($field['is_required'] ?? 0) == 0 ? 'selected' : '' ?>>
                                                                                Not Required
                                                                            </option>
                                                                            <option value="1" <?= ($field['is_required'] ?? 0) == 1 ? 'selected' : '' ?>>
                                                                                Required
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </form>

                                                    </div>

                                                </div>

                                            </div>



                                        <?php



                                            break;



                                        case 'file': ?>



                                            <div draggable="true" class="text-field-view deletable">

                                                <div class="container">

                                                    <div class="section-box sub">

                                                        <div class="section-title">

                                                            <?= $field['title'] ?>

                                                            <a href="javascript:;" class="delete">

                                                                <?= $svg ?>

                                                            </a>

                                                        </div>

                                                        <form data-id="#<?= $field['key'] ?>" class="collapsed">

                                                            <div class="row">

                                                                <div class="col-md-4">

                                                                    <div class="form-group">

                                                                        <input type="text" name="title" class="title form-control" placeholder="Title" value="<?= $field['title'] ?>">

                                                                    </div>

                                                                </div>

                                                                <div class="col-md-4">

                                                                    <div class="form-group">

                                                                        <input type="text" name="key" class="key form-control" placeholder="Key" value="<?= $field['key'] ?>">

                                                                    </div>

                                                                </div>

                                                                <div class="col-md-4">

                                                                    <div class="form-group">

                                                                        <input type="text" name="column_class" class="column_class form-control" placeholder="Column" value="<?= $field['column_class'] ?>">

                                                                    </div>

                                                                </div>
                                                                <div class="col-md-4 mt-3">
                                                                    <div class="form-group">
                                                                        <select name="is_required" class="is_required form-control">
                                                                            <option value="0" <?= ($field['is_required'] ?? 0) == 0 ? 'selected' : '' ?>>
                                                                                Not Required
                                                                            </option>
                                                                            <option value="1" <?= ($field['is_required'] ?? 0) == 1 ? 'selected' : '' ?>>
                                                                                Required
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </form>

                                                    </div>

                                                </div>

                                            </div>

                                        <?php



                                            break;



                                        case 'editor': ?>

                                            <div draggable="true" class="text-field-view deletable">

                                                <div class="container">

                                                    <div class="section-box sub">

                                                        <div class="section-title">

                                                            <?= $field['title'] ?>

                                                            <a href="javascript:;" class="delete">

                                                                <?= $svg ?>

                                                            </a>

                                                        </div>

                                                        <form data-id="#<?= $field['key'] ?>" class="collapsed">

                                                            <div class="row">

                                                                <div class="col-md-4">

                                                                    <div class="form-group">

                                                                        <input type="text" name="title" class="title form-control" placeholder="Title" value="<?= $field['title'] ?>">

                                                                    </div>

                                                                </div>

                                                                <div class="col-md-4">

                                                                    <div class="form-group">

                                                                        <input type="text" name="key" class="key form-control" placeholder="Key" value="<?= $field['key'] ?>">

                                                                    </div>

                                                                </div>

                                                                <div class="col-md-4">

                                                                    <div class="form-group">

                                                                        <input type="text" name="column_class" class="column_class form-control" placeholder="Column" value="<?= $field['column_class'] ?>">

                                                                    </div>

                                                                </div>

                                                                <div class="col-md-6 mt-3">

                                                                    <div class="form-group">

                                                                        <input type="text" name="height" class="height form-control" placeholder="Height" value="<?= $field['height'] ?>">

                                                                    </div>

                                                                </div>

                                                                <div class="col-md-6 mt-3">

                                                                    <div class="form-group">

                                                                        <input type="text" name="menubar" class="menubar form-control" placeholder="Menubar">

                                                                    </div>

                                                                </div>
                                                                <div class="col-md-4 mt-3">
                                                                    <div class="form-group">
                                                                        <select name="is_required" class="is_required form-control">
                                                                            <option value="0" <?= ($field['is_required'] ?? 0) == 0 ? 'selected' : '' ?>>
                                                                                Not Required
                                                                            </option>
                                                                            <option value="1" <?= ($field['is_required'] ?? 0) == 1 ? 'selected' : '' ?>>
                                                                                Required
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </form>

                                                    </div>

                                                </div>

                                            </div>

                            <?php

                                            break;
                                    }



                                endforeach;



                            endforeach; ?>

                        </div>

                        <div class="d-none fields-array">

                            <?php foreach ($sections as $sec) : ?>

                                <ul id="<?= $sec['key'] ?>" title="<?= $sec['title'] ?>" key="<?= $sec['key'] ?>">



                                    <?php $fields = $sec['data'];



                                    foreach ($fields as $field) :

                                        $attr = '';
                                        $subattr = '';

                                        if ($field['field-type']  == 'repetitive') :

                                            foreach ($field as $attribute => $value) :

                                                if (!is_array($value)) :

                                                    $attr .= $attribute . '="' . $value . '"';

                                                endif;

                                            endforeach;
                                    ?>


                                            <li id="<?= $field['key'] ?>" <?= $attr ?>>

                                                <?php foreach ($field['subfields'] as $subfield) :

                                                    foreach ($subfield as $sub => $subval) :

                                                        $subattr .= $sub . '="' . $subval . '"';

                                                    endforeach; ?>

                                            <li id="<?= $subfield['key'] ?>" <?= $subattr ?>></li>

                                        <?php endforeach; ?>

                                        </li>

                                    <?php else :


                                            foreach ($field as $attribute => $value) :

                                                $attr .= $attribute . '="' . $value . '"';


                                            endforeach; ?>



                                        <li id="<?= $field['key'] ?>" <?= $attr ?>></li>



                                    <?php endif; ?>

                                <?php endforeach; ?>

                                </ul>

                            <?php endforeach; ?>

                        </div>

                    </div>

                </div>

            </div>

            <div class="box-footer text-center">

                <div class="row justify-content-center">

                    <div class="col-md-4">

                        <input type="text" class="form-control" id="templatetype" placeholder="Template Type" value="<?= $template['type'] ?>">

                    </div>

                    <div class="col-md-4">

                        <input type="text" class="form-control" id="templatename" placeholder="Template Name" value="<?= $template['name'] ?>">

                        <input type="hidden" name="id" id="templateid" value="<?= $template['id'] ?>">

                    </div>

                    <div class="col-md-1">

                        <button class="btn d-block btn-primary update" id="savetemplate">Save</button>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection



<style>
    .section-box {
        padding: 0;
        margin-bottom: 1rem;
        border: solid 1px #40004c;
        border-radius: 10px;
        overflow: hidden;
    }



    .section-box .section-title {
        padding: 1rem;
        font-size: 20px;
        color: #40004c;
        background: #0000001a;
        position: relative;
        display: flex;
        align-items: center;
    }



    .section-box form {
        padding: 1rem;
        transition: cubic-bezier(0.22, 0.61, 0.36, 1) 0.7s
    }



    .collapsed {
        height: 0 !important;
        padding: 0 !important;
        margin: 0 !important;
        overflow: hidden !important;
    }



    .sub {
        margin-left: 1rem;
    }



    a.delete {
        position: absolute;
        right: 10px;
        padding: 0.5rem;
        cursor: pointer;
        background: #40004c;
    }



    .delete svg {
        width: 10px;
        height: 10px;
    }



    .delete svg path {
        fill: #ffff
    }

    #reset {
        position: absolute;
        top: 5px;
        right: 0;
    }
</style>