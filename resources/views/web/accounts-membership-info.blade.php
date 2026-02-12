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
    @if(!empty($data['content']['s1_head']))
        <h1>{{ $data['content']['s1_head'] }}</h1>
        @if(!empty($data['content']['s1_text']))
            <p>{!! $data['content']['s1_text'] !!}</p>
        @endif
    @endif

    @if(!empty($data['content']['s2_head']))
        <h1>{{ $data['content']['s2_head'] }}</h1>
        @if(!empty($data['content']['sec2_text']))
            <p>{!! $data['content']['sec2_text'] !!}</p>
        @endif
    @endif

    @if(!empty($data['content']['s3_head']))
        <h1>{{ $data['content']['s3_head'] }}</h1>
        @if(!empty($data['content']['s3_text']))
            <p>{!! $data['content']['s3_text'] !!}</p>
        @endif
    @endif

    @if(!empty($data['content']['s4_head']))
        <h1>{{ $data['content']['s4_head'] }}</h1>
        @if(!empty($data['content']['s4_text']))
            <p>{!! $data['content']['s4_text'] !!}</p>
        @endif
    @endif

    @if(!empty($data['content']['s5_head']))
        <h1>{{ $data['content']['s5_head'] }}</h1>
        @if(!empty($data['content']['s5_text']))
            <p>{!! $data['content']['s5_text'] !!}</p>
        @endif
    @endif

    @if(!empty($data['content']['s6_head']))
        <h1>{{ $data['content']['s6_head'] }}</h1>
        @if(!empty($data['content']['s6_text']))
            <p>{!! $data['content']['s6_text'] !!}</p>
        @endif
    @endif

    @if(!empty($data['content']['s7_head']))
        <h1>{{ $data['content']['s7_head'] }}</h1>
        @if(!empty($data['content']['s7_text']))
            <p>{!! $data['content']['s7_text'] !!}</p>
        @endif
    @endif

    @if(!empty($data['content']['s8_head']))
        <h1>{{ $data['content']['s8_head'] }}</h1>
        @if(!empty($data['content']['s8_text']))
            <p>{!! $data['content']['s8_text'] !!}</p>
        @endif
    @endif

    @if(!empty($data['content']['s9_head']))
        <h1>{{ $data['content']['s9_head'] }}</h1>
        @if(!empty($data['content']['s9_text']))
            <p>{!! $data['content']['s9_text'] !!}</p>
        @endif
    @endif

    @if(!empty($data['content']['s10_head']))
        <h1>{{ $data['content']['s10_head'] }}</h1>
        @if(!empty($data['content']['s10_text']))
            <p>{!! $data['content']['s10_text'] !!}</p>
        @endif
    @endif

    @if(!empty($data['content']['s11_head']))
        <h1>{{ $data['content']['s11_head'] }}</h1>
        @if(!empty($data['content']['s11_text']))
            <p>{!! $data['content']['s11_text'] !!}</p>
        @endif
    @endif

    @if(!empty($data['content']['s12_head']))
        <h1>{{ $data['content']['s12_head'] }}</h1>
        @if(!empty($data['content']['s12_text']))
            <p>{!! $data['content']['s12_text'] !!}</p>
        @endif
    @endif

    @if(!empty($data['content']['s13_head']))
        <h1>{{ $data['content']['s13_head'] }}</h1>
        @if(!empty($data['content']['s13_text']))
            <p>{!! $data['content']['s13_text'] !!}</p>
        @endif
    @endif

    @if(!empty($data['content']['s14_head']))
        <h1>{{ $data['content']['s14_head'] }}</h1>
        @if(!empty($data['content']['s14_text']))
            <p>{!! $data['content']['s14_text'] !!}</p>
        @endif
    @endif

    @if(!empty($data['content']['s15_head']))
        <h1>{{ $data['content']['s15_head'] }}</h1>
        @if(!empty($data['content']['s15_text']))
            <p>{!! $data['content']['s15_text'] !!}</p>
        @endif
    @endif

    @if(!empty($data['content']['s16_head']))
        <h1>{{ $data['content']['s16_head'] }}</h1>
        @if(!empty($data['content']['s16_text']))
            <p>{!! $data['content']['s16_text'] !!}</p>
        @endif
    @endif

    @if(!empty($data['content']['s17_head']))
        <h1>{{ $data['content']['s17_head'] }}</h1>
        @if(!empty($data['content']['s17_text']))
            <p>{!! $data['content']['s17_text'] !!}</p>
        @endif
    @endif

    @if(!empty($data['content']['s18_head']))
        <h1>{{ $data['content']['s18_head'] }}</h1>
        @if(!empty($data['content']['s18_text']))
            <p>{!! $data['content']['s18_text'] !!}</p>
        @endif
    @endif

    @if(!empty($data['content']['s19_head']))
        <h1>{{ $data['content']['s19_head'] }}</h1>
        @if(!empty($data['content']['s19_text']))
            <p>{!! $data['content']['s19_text'] !!}</p>
        @endif
    @endif
</div>

  </section>

  @endsection