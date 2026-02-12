@extends('admin.layout')



@section('content')



<div class="content-wrapper">

    <section class="content-header">
        <h1>Edit Review</h1>
        <ol class="breadcrumb">

            <li>

                <a href="{{ asset('admin/reviews/') }}">

                    Back

                </a>

            </li>

        </ol>

    </section>

    <section class="content">

        <div class="box">

            @if(session()->has('success'))

            <div class="box-info">

                <div class="alert alert-success">

                    {{ session()->get('success') }}

                </div>

            </div>
            @endif

            {!! Form::open(array('url' =>'admin/reviews/update/','autocomplete' => 'false' , 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

            <div class="box-body">

             <div class="row">
    <!-- Hidden review ID -->
    <input type="hidden" name="review_ID" value="<?= $result['review_ID'] ?>">

    <!-- Product Image Block -->
    <div class="col-md-4">
        <div class="form-group">
            <label class="control-label mb-1">Product</label>
            <a target="_blank" class="border p-3 d-block" href="<?= asset('product/' . $result['product']['prod_slug']) ?>">
                <figure class="mb-2">
                    <img src="<?= asset($result['product']['prod_image']) ?>" class="img-fluid w-100">
                </figure>
                <figcaption>
                    <strong><?= $result['product']['prod_title'] ?></strong> |
                    AED <?= $result['product']['price'] ?>
                </figcaption>
            </a>
        </div>
    </div>

    <!-- Review Info Fields -->
    <div class="col-md-8">
        <div class="row">
            <!-- Customer -->
            <div class="col-md-6 mt-3">
                <div class="form-group">
                    <label class="control-label mb-1">Customer</label>
                    <input type="text" readonly value="<?= $result['customer']['email'] ?>" class="form-control">
                </div>
            </div>

            <!-- Product Rating -->
            <div class="col-md-6 mt-3">
                <div class="form-group">
                    <label class="control-label mb-1">Product Rating</label>
                    <input type="text" readonly value="<?= $result['object_rating'] ?>" class="form-control">
                </div>
            </div>

            <!-- Delivery Rating -->
            <div class="col-md-6 mt-3">
                <div class="form-group">
                    <label class="control-label mb-1">Delivery Rating</label>
                    <input type="text" readonly value="<?= $result['delivery_rating'] ?>" class="form-control">
                </div>
            </div>

            <!-- Review -->
            <div class="col-md-6 mt-3">
                <div class="form-group">
                    <label class="control-label mb-1">Review</label>
                    <textarea readonly class="form-control"><?= $result['review'] ?></textarea>
                </div>
            </div>

            <!-- Review Media -->
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label mb-1">Review Media</label>
                    <div class="row">
                        <?php foreach ($result['media'] as $item): ?>
                            <div class="col-md-2 mb-2">
                                <?php
                                    $ext = strtolower(pathinfo($item, PATHINFO_EXTENSION));
                                    $videoTypes = ['mp4', 'webm', 'ogg'];
                                ?>
                                <?php if (in_array($ext, $videoTypes)): ?>
                                    <video class="w-100" controls>
                                        <source src="<?= asset($item) ?>" type="video/<?= $ext ?>">
                                        Your browser does not support the video tag.
                                    </video>
                                <?php else: ?>
                                    <img src="<?= asset($item) ?>" class="w-100">
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label mb-1">Status</label>
                    <select name="approved" class="form-control">
                        <option value="0" <?= $result['approved'] == 0 ? 'selected' : '' ?>>Not Approved</option>
                        <option value="1" <?= $result['approved'] == 1 ? 'selected' : '' ?>>Approved</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>



            </div>

            <div class="box-footer text-center">

                <button type="submit" class="btn btn-primary">Submit</button>

            </div>

        </div>


        {!! Form::close() !!}

</div>

</section>

</div>


@endsection