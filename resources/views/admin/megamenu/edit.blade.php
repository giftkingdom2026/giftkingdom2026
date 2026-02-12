@extends('admin.layout')

@section('content')



<div class="content-wrapper">

    <section class="content-header">



        <h1>Add Mega Menu</h1>



        <ol class="breadcrumb">

            <li>

                <a href="<?=asset('admin/mega-menu/')?>">Back</a>

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


            {!! Form::open(array('url' =>'admin/megamenu/update/', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

            <input type="hidden" name="ID" value="<?=$result['menu']['ID']?>">
            <div class="box-body">

                <div class="row">

                    <div class="col-md-8">

                        <div class="form-group">

                            <label for="name" class="control-label mb-1">Title</label>

                            <input type="text" name="menu_title" value="<?=$result['menu']['menu_title']?>" class="pagetitle form-control" required>

                        </div>

                        <div class="form-group mt-3 ">

                            <label for="category_ID" class="control-label mb-1">Menu Category</label>

                            <select name="category_ID" class="form-control select2" id="category_ID">

                                <?php

                                foreach($result['categories'] as $cat) : 

                                    $attr = $result['menu']['category_ID'] == $cat['category_ID'] ? 'selected' : ''; ?>

                                    <option <?=$attr?> value="<?=$cat['category_ID']?>"><?=$cat['category_title']?></option>

                                <?php endforeach;?>

                            </select>

                        </div>


                        <div class="form-group mt-3">

                            <label for="offers" class="control-label mb-1">Offers</label>

                            <select name="offers[]" multiple class="form-control select2" id="offers">

                                <?php

                                $arr = $result['menu']['menu_offers'] != '' ? unserialize($result['menu']['menu_offers']) : [];

                                foreach($result['offers'] as $offer) : 

                                    $attr = in_array($offer['ID'], $arr) ? 'selected' : '';?>

                                    <option <?=$attr?> value="<?=$offer['ID']?>"><?=$offer['post_title']?></option>

                                <?php endforeach;?>

                            </select>

                        </div>
                   


                </div>

                <div class="col-md-4">

                    <div class="form-group mt-3">

                        <label for="category_icon" class="control-label mb-1">Category Icon</label>

                        <div class="featuredWrap featured">

                            <button class="btn uploader category_icon btn-primary" data-type="single">+</button>

                            <input type="hidden" id="category_icon" name="category_icon" value="<?=$result['menu']['category_icon']['id']?>">

                            <img src="<?=asset($result['menu']['category_icon']['path'])?>" alt="category_icon" class="w-100">

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="box-footer text-center">

            <button type="submit" class="btn btn-primary">Submit</button>

        </div>

        {!! Form::close() !!}

    </div>

</section>

</div>

@endsection

