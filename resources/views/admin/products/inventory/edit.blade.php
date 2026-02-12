@extends('admin.layout')



@section('content')



<div class="content-wrapper">

    <section class="content-header">
        <h1>Edit Inventrory</h1>
        <ol class="breadcrumb">

            <li>

                <a href="{{ asset('admin/product/inventory') }}">

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


            {!! Form::open(array('url' =>'admin/product/inventory/update','autocomplete' => 'false' , 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

            <div class="box-body">

                <div class="row">
                    <input type="hidden" name="ID" value="<?=$data['ID']?>">
                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="name" class="control-label mb-1">Stock</label>

                            <input type="text" name="prod_quantity" class="form-control" value="<?=$data['prod_quantity']?>"> 

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="name" class="control-label  mb-1">Purchase Price Per Unit</label>

                            <input type="number" name="purchase_price" class="form-control" value="<?=$data['purchase_price']?>">

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

