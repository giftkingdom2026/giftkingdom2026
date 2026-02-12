

<table id="example1" class="table table-bordered table-striped">

    <thead>

        <tr>

            <th>ID</th>

            <th>Title</th>

            <th>Image</th>

            <th>Slug</th>

            <th>Actions</th>

        </tr>

    </thead>

    <tbody class="draggable-container">

        @if( !empty($data['brands']) )

        @foreach ( $data['brands']['data'] as  $key=> $term )

        <tr>

            <td>{{$term['brand_ID']}}</td>

            <td>{{$term['brand_title']}}</td>

            <td>
                <img src="<?=asset($term['brand_image'])?>" height="70" width="70">
            </td>

            <td>{{$term['brand_slug']}}</td>

            <td>

                <a href="{{asset('admin/brand/edit/'.$term['brand_ID'])}}" data-toggle="tooltip" data-placement="bottom" title="Edit" href="" class="badge bg-light-blue">
                    <i class="fas fa-edit"></i>
                </a>

                <a href="javascript:delete_popup('{{asset('admin/brand/delete')}}',{{$term['brand_ID']}});"class="badge delete-popup bg-red">

                    <i class="fa fa-trash" aria-hidden="true"></i>

                </a>

            </td>

        </tr>

        @endforeach

        @else

        @endif

    </tbody>

</table>