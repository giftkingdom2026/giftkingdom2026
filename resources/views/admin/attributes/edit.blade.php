@extends('admin.layout')

@section('content')

<div class="content-wrapper">

    <section class="content-header">

        <h1>Edit {{$data['attribute_title']}}<small></small> </h1>

        <ol class="breadcrumb">

            <li><a href="<?=asset('admin/attribute/list')?>">Back</a></li>

        </ol>

    </section>


    <section class="content">

        <div class="row">

            <div class="col-md-12">

                <div class="box">

                    <div class="box-header">

                        @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                        @endif
                        
                        <h2 class="box-title">
                            Edit {{$data['attribute_title']}}
                        </h2>
                    </div>


                    <div class="box-body">

                        <form action="{{asset('admin/attribute/update')}}" method="post">

                            @csrf

                            <input type="hidden" name="attribute_ID" class="form-data" value="{{$data['attribute_ID']}}">

                            <div id="languageWrap">

                                <div class="form-group">

                                    <label for="name" class="control-label mb-3">Title</label>

                                    <input type="text" name="attribute_title" value="{{$data['attribute_title']}}" class="pagetitle form-control form-data" required>

                                </div>

                            </div>

                            <div class="form-group my-3">

                                <label for="attribute_slug" class="control-label mb-3">Slug</label>

                                <input type="text" name="attribute_slug" value="{{$data['attribute_slug']}}" class="form-control slug form-data">

                            </div>

                            <div class="form-group my-2">
                                <label for="lang" class="control-label mb-1">Language</label>
                                <select id="change_lang" name="lang" data-url="<?=asset('admin/attribute/change_lang')?>" data-id="<?=$data['attribute_ID']?>" class="form-control">
                                    <option value="1">English</option>
                                    <option value="2">Arabic</option>
                                </select>
                            </div>

                            <div class="form-group d-none my-3">

                                <label for="parent_ID" class="control-label mb-3">Category</label>

                                <select id="parent_ID" required name="category_ID[]" multiple class="form-control">

                                    <?php 

                                    if( !empty($data['cat'] ) ) : ?>

                                      <option value="<?=$data['cat']['category_ID']?>" selected><?=$data['cat']['category_title']?></option>

                                  <?php else : ?>

                                      <option selected>None</option>

                                  <?php endif;?>

                              </select>

                          </div>

                          <button type="submit" class="btn btn-primary">Update</button>

                      </form>
                  </div>
              </div>
          </div>
      </div>

  </section>

</div>


@endsection

