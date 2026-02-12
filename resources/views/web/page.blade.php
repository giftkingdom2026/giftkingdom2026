@extends('web.layout')


@section('content')

<section class="inner-banner mt-4">

    <div class="container">

        <article class="pt-5 pb-5">

            <div class="row justify-content-between align-items-center">

                <div class="col-sm-8 col-md-6">

                    <h1 class="mb-0 wow fadeIn">@if(isset($data['content']['banner_text'])) {{$data['content']['banner_text']}} @else <?=$data['content']['pagetitle']?> @endif</h1>

                    <div class="breadcrumb mt-4 wow fadeIn">

                        <ul class="d-inline-flex align-items-center bg-transparent rounded-0 border-0 gap-2">

                            <li><a href="<?=asset('')?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Home')?></a></li>

                            <li>></li>

                            <li><a href="javascript:;"><?=$data['content']['pagetitle']?></a></li>

                        </ul>

                    </div>

                </div>
@if(isset($data['content']['banner_image']['path']))
                <div class="col-sm-4 col-md-3">

                    <figure class="overflow-hidden">

                        <img src="<?=asset($data['content']['banner_image']['path'])?>" alt="*" class="w-100 wow">

                    </figure>

                </div>
@endif
            </div>

        </article>

    </div>

</section>

<section class="main-section blog-det-section-one inner-section deliveries-sec">
    <div class="container">
      <?=isset($data['content']['content'] ) ? $data['content']['content'] : '' ?>
    </div>
  </section>

  @endsection