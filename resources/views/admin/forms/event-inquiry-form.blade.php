@extends('admin.layout')
@section('content')
<style>
    .dataTables_filter input {
        margin-bottom: 20px !important;
    }
</style>

<div class="content-wrapper">

    <section class="content-header">
        <h1>Event Inquiry List</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">All Inquiries</h3>
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
                                    <table id="eventInquiries" class="table table-bordered table-striped">
                                       <thead>
    <tr>
        <th><input type="checkbox" name="select-all" class="select-all"></th>
        <th>#</th>
        <th>Name</th>
        <th>Email</th>
        <th>Event</th>
        <th>Received</th>
        <th>Event Date</th>

        <!-- These must match their position in columns[] -->
        <th class="d-none">Phone Number</th>
        <th class="d-none">Guests</th>
        <th class="d-none">Message</th>

        <th>Action</th>
    </tr>
</thead>

                                    </table>


                                </div>
                                <div class="multi-delete" style="display: none;">
                                    <input type="hidden" name="selected_rows" value="" id="selected_rows">
                                    <a href="javascript:delete_popup('{{asset('admin/event-inquiry-delete')}}','');"
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
    function delete_popup(action, id) {

        jQuery('.delete-modal').find('form').attr('action', action)

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
        const csvFile = new Blob([csv.join("\n")], {
            type: "text/csv"
        });
        const downloadLink = document.createElement("a");

        // Set file name to 'event_inquiries.csv'
        downloadLink.download = 'event_inquiries.csv';
        downloadLink.href = window.URL.createObjectURL(csvFile);


        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }
</script>

@endsection