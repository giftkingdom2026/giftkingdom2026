@extends('admin.layout')

@section('content')

<div class="content-wrapper">

    <section class="content-header">

        <h1>Add Attributes<small></small> </h1>

        <ol class="breadcrumb">

            <li><a href="{{ asset('admin/category/list') }}">Back</a></li>

        </ol>

    </section>


    <section class="content">

        <div class="row">

            <div class="col-md-9">

                <div class="box">

                    @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                    @endif

                    <div class="box-header">

                        <h3 class="box-title">Attributes List</h3>

                    </div>

                    <div class="box-body">
                        <form method="GET" class="mb-3">
                            <div class="row align-items-center">


                                <div class="col-auto">
                                    <div class="form-group mb-0">
                                        <input type="text" name="s" value="<?= isset($_GET['s']) ? $_GET['s'] : '' ?>" placeholder="Search" class="form-control">
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="form-group mb-0">
                                        <button class="btn btn-primary" type="submit">Filter</button>
                                    </div>
                                </div>

                                <div class="col d-flex justify-content-end">
                                    <div class="form-group mb-0">
                                        <label class="mb-0">
                                            Show
                                            <select name="length" onchange="this.form.submit()" class="form-select form-select-sm d-inline w-auto mx-2">
                                                <option value="10" <?= (isset($_GET['length']) && $_GET['length'] == 10) ? 'selected' : '' ?>>10</option>
                                                <option value="25" <?= (isset($_GET['length']) && $_GET['length'] == 25) ? 'selected' : '' ?>>25</option>
                                                <option value="50" <?= (isset($_GET['length']) && $_GET['length'] == 50) ? 'selected' : '' ?>>50</option>
                                                <option value="100" <?= (isset($_GET['length']) && $_GET['length'] == 100) ? 'selected' : '' ?>>100</option>
                                            </select>
                                            entries
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </form>
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
    @if (!empty($data['attributes']['data']))
        @foreach ($data['attributes']['data'] as $term)
            <tr>
                <td>{{ $term['attribute_ID'] }}</td>
                <td>{{ $term['attribute_title'] }}</td>
                <td>{{ $term['attribute_slug'] }}</td>
                <td>
                    <a href="{{ asset('admin/attribute/edit/'.$term['attribute_ID']) }}" class="badge bg-light-blue" data-toggle="tooltip" title="Edit">
                        <i class="fas fa-edit text-white"></i>
                    </a>
                    <a href="{{ asset('admin/attribute/values/'.$term['attribute_ID']) }}" class="badge bg-light-blue" data-toggle="tooltip" title="View Values">
                        <i class="fa-solid fa-angle-right text-white"></i>
                    </a>
                    <a href="javascript:delete_popup('{{ asset('admin/attribute/delete') }}', {{ $term['attribute_ID'] }});" class="badge delete-popup bg-red">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="4">No attributes found.</td>
        </tr>
    @endif
</tbody>


                            </table>

                        </div>
<div class="row align-items-center justify-content-between mt-3">
    <div class="col-sm-12 col-md-6">
        @if (!empty($data['attributes']['paginator']))
            @php
                $p = $data['attributes']['paginator'];
                $from = ($p['current_page'] - 1) * $p['per_page'] + 1;
                $to = min($p['current_page'] * $p['per_page'], $p['total']);
            @endphp
            Showing {{ $from }} to {{ $to }} of {{ $p['total'] }} entries
        @endif
    </div>

    <div class="col-sm-12 col-md-6">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-md-end justify-content-center">
                @php
                    $queryParams = $_GET;
                    unset($queryParams['page']);
                @endphp

                @foreach ($data['attributes']['paginator']['links'] as $item)
                    @php
                        $link = $item['url'] ?? 'javascript:;';
                        $disabledClass = $item['url'] === null ? 'disabled' : '';
                        $activeClass = $item['active'] ? 'active' : '';

                        if ($item['url'] !== null && !empty($queryParams)) {
                            $separator = strpos($link, '?') === false ? '?' : '&';
                            $link .= $separator . http_build_query($queryParams);
                        }
                    @endphp
                    <li class="page-item {{ $disabledClass }} {{ $activeClass }}">
                        <a class="page-link" href="{{ htmlspecialchars($link) }}">
                            {!! $item['label'] !!}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</div>

                    </div>

                </div>

            </div>

            <div class="col-md-3">

                <div class="box">

                    <div class="box-header">
                        <h2 class="box-title">
                            Add Attribute
                        </h2>
                    </div>


                    <div class="box-body">

                        <form class="js-form" action="{{asset('admin/attribute/create')}}">

                            @csrf

                            <div class="form-group">

                                <label for="name" class="control-label mb-3">Title</label>

                                <input type="text" name="attribute_title" class="pagetitle form-control form-data" required>

                            </div>


                            <div class="form-group my-3">

                                <label for="term_slug" class="control-label mb-3">Slug</label>

                                <input type="text" name="attribute_slug" class="form-control slug form-data">

                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Insert</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>

</div>


<script>
    function delete_popup(action, id) {



        jQuery('.delete-modal').find('form').attr('action', action)



        jQuery('.delete-modal').find('#id').val(id)



        jQuery('.delete-modal').addClass('show')



        jQuery('.delete-modal').show()



    }
</script>
@endsection