@extends('admin.layout')

@section('content')
    <div class="content-wrapper">

        <section class="content-header">

            <h1>Edit Access</h1>

            <ol class="breadcrumb">

                <li>

                    <a href="<?= asset('admin/admins/') ?>">

                        Back

                    </a>

                </li>

            </ol>

        </section>

        <section class="content">

            <div class="box">

                @if (session()->has('success'))
                    <div class="box-info">

                        <div class="alert alert-success">

                            <?= session()->get('success') ?>

                        </div>

                    </div>
                @endif

                <form action="<?= url('admin/updateaccess', ['id' => $data['user']['id']]) ?>" method="POST"
                    class="form-horizontal form-validate" enctype="multipart/form-data">

                    @csrf

<div class="box-body">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <button type="button" id="selectAll" class="btn btn-primary mb-3">Select All</button>
                    <button type="button" id="unselectAll" class="btn btn-secondary mb-3">Unselect All</button>
                </div>

                <?php foreach( $data['default'] as $key => $item ) : ?>
                    <div class="col-md-4">
                        <div class="border p-3 mt-3">
                            <div class="form-group">
                                <label for="<?= $item ?>" class="gap-2 mb-0 d-flex align-items-center">
                                    <?php
                                    $attr = isset($data['arr'][$item]) && $data['arr'][$item] == 'on' ? 'checked' : ''; ?>
                                    <input type="hidden" name="<?= $item ?>" value="off">
                                    <input type="checkbox" <?= $attr ?> id="<?= $item ?>" name="<?= $item ?>" class="form-checkbox">
                                    <?= ucwords(str_replace('-', ' ', $item)) ?>
                                </label>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</div>


                    <div class="box-footer text-center">

                        <button type="submit" class="btn btn-primary">Submit</button>

                    </div>

                    </form>

            </div>

        </section>

    </div>
@endsection

<script>
    function delete_popup(action, id) {

        jQuery('.delete-modal').find('form').attr('action', action)

        jQuery('.delete-modal').find('#id').val(jQuery('#selected_rows').val())

        jQuery('.delete-modal').addClass('show')

        jQuery('.delete-modal').show()
    }
</script>
