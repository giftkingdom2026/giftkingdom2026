@extends('admin.layout')



@section('content')

<div class="content-wrapper">

    <section class="content-header">

        <h1>Wallet History</h1>

    </section>

    <section class="content">

        <div class="row">

            <div class="col-md-12">

                <div class="box">

                    <div class="box-header">

                        <h3 class="box-title">Listing</h3>

                    </div>

                    <div class="box-body">

                        <div class="row">

                            <div class="col-xs-12">

                                <table id="customersWallet" class="table table-bordered table-striped">

                                    <thead>

                                        <tr >

                                            <th>ID</th>

                                            <th>Customer Email</th>

                                            <th>Type</th>

                                            <th>Status</th>

                                            <th>Points</th>

                                            <th>Comment</th>

                                            <th>Date</th>

                                            <th>Action</th>

                                        </tr>

                                    </thead>

                                </table>
                            </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

</div>

<style type="text/css">
    .success td{color: green}
    .danger td{color: red}
</style>
@endsection
