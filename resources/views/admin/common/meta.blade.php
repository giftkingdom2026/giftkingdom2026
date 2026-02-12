<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Admin Panel | </title>
  <link rel="icon" type="image/x-icon" href="{{ url('/assets/images/favicon.png') }}" />
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="Themescoder" content="">
    <link rel="icon" type="image/x-icon" href="<?=asset('favicon.ico')?>">

  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
  <link href="{!! asset('admin/bootstrap/css/styles.css') !!} " media="all" rel="stylesheet" type="text/css" />
  <link href="{!! asset('admin/css/jquery.fancybox.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="{!! asset('admin/plugins/colorpicker/bootstrap-colorpicker.min.css') !!} ">
  <link rel="stylesheet" href="{!! asset('admin/plugins/timepicker/bootstrap-timepicker.min.css') !!} ">
  <link rel="stylesheet" href="{!! asset('admin/plugins/datepicker/datepicker3.css') !!} ">
  <link href="{!! asset('admin/dist/css/AdminLTE.min.css')  !!} " media="all" rel="stylesheet" type="text/css" />  
  <link href="{!! asset('admin/css/select2.min.css')  !!} " media="all" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
  <link href="{!! asset('admin/dist/css/skins/_all-skins.min.css') !!} " media="all" rel="stylesheet" type="text/css" />
  <link href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/sc-2.1.1/datatables.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <script type="text/javascript">
      window.csrf_token = "{{ csrf_token() }}"
   </script>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script>window.jQuery || document.write('<script src="../../assets/js/jquery-2.2.4.min"><\/script>')</script>

  <![endif]-->
</head>

<style>
.dragable-box-cursor img{
  cursor: move;
}

.order-list{
  list-style-type: none;
}
.tabs-content{width: 100%}

.myAccordions .accordion {
    background: linear-gradient(to bottom right, #f1f1f1, #d4d3d3);
    margin: 0 auto 15px;
    box-shadow: 0 10px 15px -20px rgba(0, 0, 0, 0.3), 0 30px 45px -30px rgba(0, 0, 0, 0.3), 0 80px 55px -30px rgba(0, 0, 0, 0.1);
}

.myAccordions .heading {
    font-size: 14px;
    border-bottom: 1px solid #e7e7e7;
    letter-spacing: 0.8px;
    padding: 15px;
    cursor: pointer;
    transition: 0.5s;
}

.myAccordions .heading:nth-last-child(2) {
    border-bottom: 0;
}

.myAccordions .heading:hover {
    background: #1a1919;
    color: #fff;
    border-radius: 0;
}

.myAccordions .heading::before {
    content: '';
    vertical-align: middle;
    display: inline-block;
    border-top: 7px solid #fff;
    border-left: 7px solid transparent;
    border-right: 7px solid transparent;
    float: right;
    transform: rotate(0);
    transition: all 0.5s;
    margin-top: 10px;
}

.myAccordions .active.heading::before {
    transform: rotate(-180deg);
}

.myAccordions .not-active.heading::before {
    transform: rotate(0deg);
}

.myAccordions .contents {
    display: none;
    background: #fafafa;
    padding: 25px;
}

.myAccordions .contents ul {
}

.myAccordions .contents ul li {
    margin-bottom: 10px;
    position: relative;
    padding-left: 10px;
}

/*.myAccordions .contents ul li::before {
    content: '';
    position: absolute;
    left: 0;
    top: 7px;
    background-color: #4a2c9d;
    height: 5px;
    width: 5px;
    border-radius: 50%;
}*/

.myAccordions .contents p {
    margin-bottom: 25px;
}

.myAccordions .contents p:last-of-type {
    margin-bottom: 0
}

.myAccordions .contents p strong {
    font-weight: 500;
    display: inline-block;
    margin-bottom: 10px;
}


</style>
