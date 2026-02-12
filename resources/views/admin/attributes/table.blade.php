
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

        @if( !empty($data['attributes']['data']) )

        @foreach ( $data['attributes']['data'] as  $key=> $term )

        <tr>

            <td>{{$term['attribute_ID']}}</td>

            <td>{{$term['attribute_title']}}</td>

            <td>{{$term['attribute_slug']}}</td>

            <td>

                <a href="{{asset('admin/attribute/edit/'.$term['attribute_ID'])}}" data-toggle="tooltip" data-placement="bottom" title="Edit" href="" class="badge bg-light-blue">
                    <i class="fas fa-edit text-white"></i>
                </a>

                <a href="{{asset('admin/attribute/values/'.$term['attribute_ID'])}}" data-toggle="tooltip" data-placement="bottom" title="Edit" href="" class="badge bg-light-blue">
                    <i class="fa-solid fa-angle-right text-white"></i>
                </a>

                <a href="javascript:delete_popup('{{asset('admin/attribute/delete')}}',{{$term['attribute_ID']}});"class="badge delete-popup bg-red">

                    <i class="fa fa-trash" aria-hidden="true"></i>

                </a>

            </td>

        </tr>

        @endforeach

        @else

        @endif

    </tbody>

</table>
