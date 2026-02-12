@extends('admin.layout')



@section('content')



<div class="content-wrapper">

    <section class="content-header">
        <h1>Edit Question</h1>
        <ol class="breadcrumb">

            <li>

                <a href="{{ asset('admin/questions/') }}">

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


            {!! Form::open(array('url' =>'admin/questions/update/','autocomplete' => 'false' , 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

            <div class="box-body">

                <div class="row">

                    <div class="col-md-12">

                        <input type="hidden" name="comment_ID" value="<?=$result['comment_ID']?>">
                        <input type="hidden" name="product_ID" value="<?=$result['product_ID']?>">
                        
                        <div class="row">

                            <div class="col-md-12">

                                <div class="form-group">

                                    <label for="name" class="control-label mb-1">Question</label>

                                    <textarea readonly class="form-control"><?=$result['comment']?></textarea>

                                </div>
                                
                                <?php
                                
                                if( !empty($result['answers']) ) : ?>

                                    <div class="mt-3 ms-3"><strong>Previous Answers:</strong></div>

                                    <?php foreach($result['answers'] as $answer) : ?>

                                        <p class="border ms-5 mt-2 p-1"><?=$answer['comment']?></p>

                                    <?php endforeach;

                                endif;?>

                                <div class="form-group ms-5 mt-3">

                                    <label for="name" class="control-label mb-1">Answer</label>

                                    <textarea name="answer" required class="form-control"></textarea>

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

