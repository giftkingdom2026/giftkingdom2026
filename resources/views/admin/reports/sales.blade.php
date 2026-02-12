@extends('admin.layout')


@section('content')


<div class="content-wrapper">

  <section class="content-header">

    <h1>Sales Report</h1>

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

                @if(session()->has('success'))

                <div class="alert alert-success">

                  <?=session()->get('success') ?>

                </div>

                @endif

              </div>

            </div>

            <div class="row">

              <div class="col-xs-3">

                <h2>Grand Total: AED <?=number_format($result['total'],2)?></h2>

              </div>
              <div class="col-xs-9">

                <table id="salesReport" class="table table-bordered table-striped">

                  <thead>

                    <tr>

                      <th>ID</th>

                      <th>Customer Email</th>

                      <th>Total</th>

                      <th>Date</th>

                    </tr>

                  </thead>


                  </table>

                  <div class="multi-delete" style="display: none;">

                    <input type="hidden" name="selected_rows" value="" id="selected_rows">

                    <a href="javascript:delete_popup('{{asset('admin/deletepost')?>','');" 

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


  @endsection


  <script>

    function delete_popup(action,id){

      jQuery('.delete-modal').find('form').attr('action',action)

      jQuery('.delete-modal').find('#id').val(jQuery('#selected_rows').val())

      jQuery('.delete-modal').addClass('show')

      jQuery('.delete-modal').show()

    }

  </script>