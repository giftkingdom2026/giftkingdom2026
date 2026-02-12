
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