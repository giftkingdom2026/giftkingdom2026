@extends('admin.layout')


@section('content')


<div class="content-wrapper">

  <section class="content-header">

    <h1>Low Stock Products</h1>

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

              <div class="col-xs-12">

                <table id="lowStockTable" class="table table-bordered table-striped">

                  <thead>

                    <tr>

                      <th>ID</th>

                      <th>Image</th>

                      <th>Product</th>

                      <th>Remaining Stock</th>

                      <th>Actions</th>

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


  @endsection


  <script>

    function delete_popup(action,id){

      jQuery('.delete-modal').find('form').attr('action',action)

      jQuery('.delete-modal').find('#id').val(jQuery('#selected_rows').val())

      jQuery('.delete-modal').addClass('show')

      jQuery('.delete-modal').show()

    }

  </script>