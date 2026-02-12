@extends('admin.layout')

@section('content')

<div class="content-wrapper">

    <section class="content-header">

        <h1>Add Values<small></small> </h1>

        <ol class="breadcrumb">

            <li><a href="{{ asset('admin/attribute/list') }}">Back</a></li>

        </ol>

    </section>


    <section class="content">

        <div class="row">

            <div class="col-md-9">

                <div class="box">

                    <div class="box-header">

                        <h3 class="box-title">Values List</h3>

                    </div>

                    <div class="box-body">

                        <div class="replace-table">

                            <table id="example1" class="table table-bordered table-striped">

                                <thead>

                                    <tr>

                                        <th>ID</th>

                                        <th>Title</th>

                                        <th>Slug</th>

                                        <th>Actions</th>

                                    </tr>

                                </thead>

                                <tbody class="draggable-container">

                                    @if( !empty($data['values']) )

                                    @foreach ( $data['values'] as  $key=> $term )

                                    <tr>

                                        <td>{{$term['value_ID']}}</td>

                                        <td>{{$term['value_title']}}</td>

                                        <td>{{$term['value_slug']}}</td>

                                        <td>

                                            <a href="{{asset('admin/attribute/value/edit/'.$term['value_ID'])}}" data-toggle="tooltip" data-placement="bottom" title="Edit" href="" class="badge bg-light-blue">
                                                <i class="fas fa-edit text-white"></i>
                                            </a>

                                            <a href="javascript:delete_popup('{{asset('admin/attribute/value/delete')}}',{{$term['value_ID']}});"class="badge delete-popup bg-red">

                                                <i class="fa fa-trash" aria-hidden="true"></i>

                                            </a>

                                        </td>

                                    </tr>

                                    @endforeach

                                    @else

                                    @endif

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-3">

                <div class="box">

                    <div class="box-header">
                        <h2 class="box-title">
                            Add Value
                        </h2>
                    </div>


                    <div class="box-body">

                        <form class="js-form" action="{{asset('admin/attribute/create/value')}}">

                            @csrf

                            <div class="form-group">

                                <label for="name" class="control-label mb-3">Title</label>

                                <input type="text" name="value_title" class="pagetitle form-control form-data" required>

                            </div>


                            <div class="form-group my-3">

                                <label for="term_slug" class="control-label mb-3">Slug</label>

                                <input type="text" name="value_slug" class="form-control slug form-data">

                            </div>

                            <div class="form-group mt-3 image_div">

                                <label for="value_image" class="control-label mb-3">Image</label>

                                <div class="featuredWrap">

                                    <button class="btn uploader featured_image btn-primary" data-type="single">+</button>

                                    <input type="hidden" id="value_image" 

                                    name="value_image" class="form-data" value="">

                                    <img src="" alt="value_image" class="w-100 d-none">

                                </div>



                            </div>

                            <input type="hidden" name="attribute_ID" value="<?=$data['attr']?>">

                            <button type="submit" class="btn btn-primary mt-3">Insert</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>

</div>


<script>

// $(document).ready(function(){
//     $('body').on('change','.value_type',function(){
//         alert('a');
//         if($(this).val() == 'text'){
//             $('.image_div').css('display','none');
//         }else{
//             $('.image_div').css('display','block');
//         }
//     });
// });

 function delete_popup(action,id){



    jQuery('.delete-modal').find('form').attr('action',action)



    jQuery('.delete-modal').find('#id').val(id)



    jQuery('.delete-modal').addClass('show')



    jQuery('.delete-modal').show()



}

</script>
@endsection

