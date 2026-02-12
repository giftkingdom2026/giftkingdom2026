@extends('admin.layout')
@section('content')
<style>
    .dataTables_filter input {
        margin-bottom: 20px !important;
    }
</style>
<div class="content-wrapper">

    <section class="content-header">
        <h1>Design Form List</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Design Form List</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">

                                @if(session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session()->get('success') }}
                                </div>
                                @endif

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>


                                            <th></th>
                                            <th>@sortablelink('Name', trans('labels.Name') )</th>
                                            <th>Designation</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Location</th>
                                            <th>Message</th>
                                            <th>Received Date</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if( !empty($result['list'] ))
                                        @foreach ($result['list'] as  $key=>$data)

                                        <tr id="row-{{ $data->id }}">
                                            <td>
                                                <input type="checkbox" name="select" class="row-select" data-id="{{ $data->id }}">
                                            </td>
                                            <td>
                                                {{ $data->name }}
                                            </td>

                                             <td>
                                                {{ $data->design }}
                                            </td>
                                          
                                            <td>
                                                {{ $data->email }}
                                            </td>

                                            <td>
                                                {{ $data->phone }}
                                            </td>

                                            <td>
                                                {{ $data->location }}
                                            </td>

                                            <td>
                                                {{ $data->message }}
                                            </td>

                                            <td data-order="{{ strtotime($data->created_at) }}">
                                                {{ date('d m Y' , strtotime($data->created_at)) }}
                                            </td>

                                            <td>

                                                <a href="javascript:delete_popup('{{asset('admin/design-delete')}}',{{ $data->id }});" 
                                                class="badge delete-popup bg-red">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                        </td>

                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="6">{{ trans('labels.NoRecordFound') }}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            </div>
                            <div class="multi-delete" style="display: none;">
                                <input type="hidden" name="selected_rows" value="" id="selected_rows">
                                <a href="javascript:delete_popup('{{asset('admin/design-delete')}}','');" 
                                class="badge delete-multiple-popup bg-red">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</section>
</div>

<script>

    function delete_popup(action,id){

        jQuery('.delete-modal').find('form').attr('action',action)

        jQuery('.delete-modal').find('#id').val(id)

        jQuery('.delete-modal').addClass('show')

        jQuery('.delete-modal').show()

    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/sc-2.1.1/datatables.min.js"></script>
<script>
function exportTableToCSV() {
    let csv = [];
    const rows = document.querySelectorAll("#example1 tr");

    rows.forEach((row, rowIndex) => {
        let rowData = [];
        
        // Add serial number as the first column
        rowData.push(rowIndex === 0 ? "S.No." : rowIndex); 

        const cells = row.querySelectorAll("td, th");
        cells.forEach((cell, index) => {
            // Exclude the first and last columns
            if (index !== 0 && index !== cells.length - 1) {
                rowData.push(cell.innerText);
            }
        });

        csv.push(rowData.join(","));
    });

    // Create CSV file content
    const csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
    const downloadLink = document.createElement("a");

    // Set file name to 'contact_requests.csv'
    downloadLink.download = 'contact_requests.csv';
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Trigger download
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}
</script>
<script>
$(document).ready(function() {

    $.fn.dataTable.ext.type.order['custom-date-dd-mm-yyyy-pre'] = function(data) {
        if (!data) return 0; 
        var dateParts = data.split("-");
        return new Date(dateParts[2], dateParts[1] - 1, dateParts[0]).getTime(); 
    };

    var table = $('#example1').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'csvHtml5',
                text: 'Export to CSV',
                title: 'Contact-Form-List',
                className: 'btn btn-primary mb-4',
                filename: 'Contact-Form-List',
            }
        ],
        paging: true,
        searching: true,
        ordering: true,
        responsive: true,
        columnDefs: [
            {
                targets: 7,
                type: "custom-date-dd-mm-yyyy" 
            }
        ],
        order: [[7, 'desc']], 
        drawCallback: function(settings) {
            
        } 
    });

});
</script>
@endsection