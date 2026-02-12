
<style>
.force-display-none {
    display: none !important;
}

.force-display-block {
    display: block !important;
}
</style>
<section class="main-section login-section-one pb-0 overflow-hidden position-relative">
            <div class="container-fluid p-0">
                <div class="row">
                    <div class="col-md-5">
                        <figure class="h-100"><img src="{{asset($result['commonContent']['logout-banner']->path)}}" class="w-100 h-100" alt="*"></figure>
                    </div>
                    <div class="col-md-7">
                        <figcaption>
                            <div class="tabsWrapper">
                            <div class="devTab d-flex align-items-center gap-5">
                                <ul class="sec1Tab mb-5 pb-2">
                                    <li class="first">
                                        <a href="javascript:;" id="loginTabLink" class="tablink" data-tab="#tab0">LOG IN</a>
                                    </li>
                                                        
                                    <li>
                                        <a href="javascript:;" class="tablink <?php if(isset($_GET['is_signup']) && $_GET['is_signup'] == 1) echo 'active'; ?>" data-tab="#tab1">Sign Up</a>
                                    </li>
                                </ul>
                            </div>
                        <div class="tabArea">
                            <div id="tab0" class="icon-cls tabPnl <?php if(isset($_GET['is_signup']) && $_GET['is_signup'] == 1) echo 'force-display-none'; ?>">
                                <div class="sec3TabWrp">
                                    @if(Session::has('loginError'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        <span class="">@lang('website.Error'):</span>
                                        {!! session('loginError') !!}

                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @endif
                                    @if(Session::has('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        <span class="">@lang('website.success'):</span>
                                        {!! session('success') !!}

                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @endif
                                    <form  enctype="multipart/form-data"   action="{{ URL::to('/process-login')}}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control" placeholder="Email address" required="">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" id="log-password" name="password" class="form-control icon-eye" placeholder="Password" required="">
                                             <span class="log-password-cls">
                                                <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="checkbox mb-4">
                                                    <label for="html" class="d-flex align-items-center gap-2">
                                                      <input type="checkbox" id="html">
                                                      <span class="label"></span>
                                                    Remember me</label>
                                                </div>
                                            </div>
                                            <div class="col-6 text-end">
                                                <a href="{{url('forgotPassword')}}" class="forgotPass">Forgot your Password?</a>
                                            </div>
                                        </div>
                                        <button type="submit" class="blck-btn text-uppercase">Login</button>
                                        <div class="log-or my-3"><small>or</small></div>
                                        <!-- <a href="{{asset('/login/google')}}" class="google-btn"> -->
                                        <a href="javascript:;" class="google-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="29.985" height="29.996" viewBox="0 0 29.985 29.996">
                                              <g id="Group_40258" data-name="Group 40258" transform="translate(641.152 191.649)">
                                                <path id="Path_8314" data-name="Path 8314" d="M-441.079-25.363c.253-.194.535-.345.789-.54a9.6,9.6,0,0,0,1.672-1.612,9.552,9.552,0,0,0,1.336-2.3.188.188,0,0,0,0-.136h-7.911c-.057-.247-.079-5.175-.031-5.894.239-.052,14.126-.051,14.381.006.045.274.071.471.132.841a16.348,16.348,0,0,1,.071,3.155,12.693,12.693,0,0,1-.173,1.347,14.307,14.307,0,0,1-.4,1.71,14.872,14.872,0,0,1-1.483,3.381,13.892,13.892,0,0,1-1.641,2.247c-.422.471-.883.909-1.344,1.343a1.776,1.776,0,0,1-.522.406c-.582-.42-1.112-.9-1.671-1.352-.378-.3-.746-.62-1.121-.927s-.781-.636-1.173-.952C-440.471-24.882-440.776-25.122-441.079-25.363Z" transform="translate(-180.569 -143.575)" fill="#518ef7"/>
                                                <path id="Path_8315" data-name="Path 8315" d="M-600.4,44.831c.3.241.608.481.91.724q.589.474,1.173.952c.375.307.743.624,1.121.927.559.448,1.09.931,1.672,1.352a.437.437,0,0,1-.162.164,14.888,14.888,0,0,1-3.648,2.1,14.307,14.307,0,0,1-4.368,1.011c-.042,0-.075.012-.089.056h-2.284c-.014-.043-.046-.054-.088-.057a14.5,14.5,0,0,1-3.79-.818,14.823,14.823,0,0,1-4.274-2.38,15,15,0,0,1-3.325-3.687,6.091,6.091,0,0,1-.545-.959l.832-.678,1.192-.973,1.349-1.1,1.463-1.191c.13.28.256.562.392.84a8.424,8.424,0,0,0,1.7,2.35,8.852,8.852,0,0,0,4.536,2.4,8.9,8.9,0,0,0,2.408.15,8.794,8.794,0,0,0,3.567-1.048C-600.579,44.915-600.491,44.874-600.4,44.831Z" transform="translate(-21.245 -213.768)" fill="#28b346"/>
                                                <path id="Path_8316" data-name="Path 8316" d="M-619.573-183.513a9.063,9.063,0,0,1,.824-1.435,14.561,14.561,0,0,1,1.578-1.984,14.757,14.757,0,0,1,4-3.03,14.319,14.319,0,0,1,4.011-1.4c.6-.111,1.2-.191,1.813-.244a13.153,13.153,0,0,1,1.78-.028,15.274,15.274,0,0,1,2.418.312,14.835,14.835,0,0,1,3.552,1.235,14.32,14.32,0,0,1,2.625,1.669l.28.223-4.807,3.934a.3.3,0,0,1-.224-.059,9.132,9.132,0,0,0-2.806-1.073,9.084,9.084,0,0,0-2.379-.151,8.649,8.649,0,0,0-2.4.513,8.879,8.879,0,0,0-2.683,1.548,8.768,8.768,0,0,0-2.356,3.078c-.126.272-.237.55-.356.826-.278-.192-.531-.414-.788-.632-.382-.323-.777-.63-1.164-.946-.261-.213-.518-.432-.78-.645-.366-.3-.734-.591-1.1-.887C-618.88-182.963-619.206-183.263-619.573-183.513Z" transform="translate(-19.89 0)" fill="#f04336"/>
                                                <path id="Path_8317" data-name="Path 8317" d="M-639.463-87.692c.367.25.693.55,1.037.828.367.3.735.589,1.1.887.262.213.518.432.78.645.388.316.783.623,1.164.946.257.218.51.44.788.632-.1.419-.244.828-.312,1.257a9.564,9.564,0,0,0-.152,1.233,8.975,8.975,0,0,0,.069,1.654,8.8,8.8,0,0,0,.453,1.816.639.639,0,0,1,.022.114l-1.463,1.191-1.349,1.1-1.192.973-.832.678a13.237,13.237,0,0,1-1.212-2.909,14.334,14.334,0,0,1-.457-2.153c-.045-.306-.058-.619-.09-.928a12.161,12.161,0,0,1-.035-1.605,15.644,15.644,0,0,1,.209-2.022,15.313,15.313,0,0,1,.722-2.712,15.092,15.092,0,0,1,.635-1.464A.348.348,0,0,1-639.463-87.692Z" transform="translate(0 -95.821)" fill="#faba01"/>
                                              </g>
                                            </svg>
                                            <strong class="ms-2">Continue with Google</strong>
                                        </a>
                                        <p class="mt-4">By signing in, you agree to our <a href="{{('/page/privacy-policy')}}">Privacy Policy</a> & <a href="javascript:;">Terms of Use.</a></p>
                                    </form>
                                </div>
                            </div>
                        
                            <div id="tab1" class="icon-cls tabPnl <?php if(isset($_GET['is_signup']) && $_GET['is_signup'] == 1) echo 'force-display-block';  ?>">
                                <div class="sec3TabWrp">
                                    @if( count($errors) > 0)
                                    @foreach($errors->all() as $error)
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        <span class="sr-only">@lang('website.Error'):</span>
                                        {{ $error }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @endforeach
                                    @endif

                                    @if(Session::has('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        <span class="sr-only">@lang('website.Error'):</span>
                                        {!! session('error') !!}

                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @endif
                                    <div class="sec3TabWrp">
                                    <form name="signup" enctype="multipart/form-data"  action="{{ URL::to('/signupProcess')}}" method="post">
                                        {{csrf_field()}}                    
                                         <!-- div class="form-group">
                                            <input type="text" class="form-control" placeholder="First Name">
                                        </div> -->
                                        <div class="form-group">
                                            <input  name="firstName" type="text" class="form-control"  required="" id="firstName" placeholder="First Name" value="">
                                            <span class="help-block" hidden>@lang('website.Please enter your first name')</span>
                                        </div>
                                        <!-- <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Last Name">
                                        </div> -->
                                        <div class="form-group">
                                            <input  name="lastName" type="text" class="form-control " required="" id="lastName" placeholder="Last Name" value="">
                                            <span class="help-block" hidden>@lang('website.Please enter your last name')</span>
                                        </div>
                                       <!--  <div class="form-group">
                                            <input type="email" class="form-control" placeholder="Email">
                                        </div> -->
                                        <div class="form-group">
                                            <input  name="email" type="text" class="form-control" required="" id="inlineFormInputGroup" placeholder="Email" value="">
                                            <span class="help-block" hidden>@lang('website.Please enter your valid email address')</span>
                                        </div>
                                      <!--   <div class="form-group">
                                            <input type="password" class="form-control" placeholder="Password">
                                        </div> -->
                                        <div class="form-group">
                                                <input name="password" id="password" type="password" class="form-control icon-eye" required=""  placeholder="Password">
                                                <span class="toggle-password">
                                                    <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                                </span>
                                                <span class="help-block" hidden>@lang('website.Please enter your password')</span>
                                        </div>
                                        <button type="submit" class="blck-btn text-uppercase">Register</button>
                                        <div class="log-or my-4"><small>or</small></div>
                                        <a href="javascript:;" class="google-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="29.985" height="29.996" viewBox="0 0 29.985 29.996">
                                              <g id="Group_40258" data-name="Group 40258" transform="translate(641.152 191.649)">
                                                <path id="Path_8314" data-name="Path 8314" d="M-441.079-25.363c.253-.194.535-.345.789-.54a9.6,9.6,0,0,0,1.672-1.612,9.552,9.552,0,0,0,1.336-2.3.188.188,0,0,0,0-.136h-7.911c-.057-.247-.079-5.175-.031-5.894.239-.052,14.126-.051,14.381.006.045.274.071.471.132.841a16.348,16.348,0,0,1,.071,3.155,12.693,12.693,0,0,1-.173,1.347,14.307,14.307,0,0,1-.4,1.71,14.872,14.872,0,0,1-1.483,3.381,13.892,13.892,0,0,1-1.641,2.247c-.422.471-.883.909-1.344,1.343a1.776,1.776,0,0,1-.522.406c-.582-.42-1.112-.9-1.671-1.352-.378-.3-.746-.62-1.121-.927s-.781-.636-1.173-.952C-440.471-24.882-440.776-25.122-441.079-25.363Z" transform="translate(-180.569 -143.575)" fill="#518ef7"/>
                                                <path id="Path_8315" data-name="Path 8315" d="M-600.4,44.831c.3.241.608.481.91.724q.589.474,1.173.952c.375.307.743.624,1.121.927.559.448,1.09.931,1.672,1.352a.437.437,0,0,1-.162.164,14.888,14.888,0,0,1-3.648,2.1,14.307,14.307,0,0,1-4.368,1.011c-.042,0-.075.012-.089.056h-2.284c-.014-.043-.046-.054-.088-.057a14.5,14.5,0,0,1-3.79-.818,14.823,14.823,0,0,1-4.274-2.38,15,15,0,0,1-3.325-3.687,6.091,6.091,0,0,1-.545-.959l.832-.678,1.192-.973,1.349-1.1,1.463-1.191c.13.28.256.562.392.84a8.424,8.424,0,0,0,1.7,2.35,8.852,8.852,0,0,0,4.536,2.4,8.9,8.9,0,0,0,2.408.15,8.794,8.794,0,0,0,3.567-1.048C-600.579,44.915-600.491,44.874-600.4,44.831Z" transform="translate(-21.245 -213.768)" fill="#28b346"/>
                                                <path id="Path_8316" data-name="Path 8316" d="M-619.573-183.513a9.063,9.063,0,0,1,.824-1.435,14.561,14.561,0,0,1,1.578-1.984,14.757,14.757,0,0,1,4-3.03,14.319,14.319,0,0,1,4.011-1.4c.6-.111,1.2-.191,1.813-.244a13.153,13.153,0,0,1,1.78-.028,15.274,15.274,0,0,1,2.418.312,14.835,14.835,0,0,1,3.552,1.235,14.32,14.32,0,0,1,2.625,1.669l.28.223-4.807,3.934a.3.3,0,0,1-.224-.059,9.132,9.132,0,0,0-2.806-1.073,9.084,9.084,0,0,0-2.379-.151,8.649,8.649,0,0,0-2.4.513,8.879,8.879,0,0,0-2.683,1.548,8.768,8.768,0,0,0-2.356,3.078c-.126.272-.237.55-.356.826-.278-.192-.531-.414-.788-.632-.382-.323-.777-.63-1.164-.946-.261-.213-.518-.432-.78-.645-.366-.3-.734-.591-1.1-.887C-618.88-182.963-619.206-183.263-619.573-183.513Z" transform="translate(-19.89 0)" fill="#f04336"/>
                                                <path id="Path_8317" data-name="Path 8317" d="M-639.463-87.692c.367.25.693.55,1.037.828.367.3.735.589,1.1.887.262.213.518.432.78.645.388.316.783.623,1.164.946.257.218.51.44.788.632-.1.419-.244.828-.312,1.257a9.564,9.564,0,0,0-.152,1.233,8.975,8.975,0,0,0,.069,1.654,8.8,8.8,0,0,0,.453,1.816.639.639,0,0,1,.022.114l-1.463,1.191-1.349,1.1-1.192.973-.832.678a13.237,13.237,0,0,1-1.212-2.909,14.334,14.334,0,0,1-.457-2.153c-.045-.306-.058-.619-.09-.928a12.161,12.161,0,0,1-.035-1.605,15.644,15.644,0,0,1,.209-2.022,15.313,15.313,0,0,1,.722-2.712,15.092,15.092,0,0,1,.635-1.464A.348.348,0,0,1-639.463-87.692Z" transform="translate(0 -95.821)" fill="#faba01"/>
                                              </g>
                                            </svg>
                                            <strong class="ms-2">Continue with Google</strong>
                                        </a>
                                        <p class="mt-4 mb-0">By signing in, you agree to our <a href="{{('/page/privacy-policy')}}">Privacy Policy</a> & <a href="javascript:;">Terms of Use.</a></p>
                                    </form>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        </figcaption>
                    </div>
                </div>
            </div>
        </section>

           <section class="main-section home-section-six login-section-two pt-0">
            <div class="container-fluid p-0">
                <div class="sec6Wrap">
                    <div class="main-heading">
                        <span class="text-white">{{$result['commonContent']['logout-banner']->text1}}</span>
                        <h2 class="text-white">{{strip_tags($result['commonContent']['logout-banner']->text2)}}</h2>
                    </div>
                    <a href="{{url('/sell-an-item')}}"><button class="button button1 hover-white btn2">Sell Now <i class="link-icon-white"></i></button></a>
                </div>
            </div>
        </section>

        @include('web.news-letter')

        @include('web.banners.facility-banners')



<script>
     
document.addEventListener("DOMContentLoaded", function () {
        const passwordInput = document.getElementById("password");
        const togglePassword = document.querySelector(".toggle-password");

        togglePassword.addEventListener("click", function () {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                togglePassword.innerHTML = '<i class="fa fa-eye" aria-hidden="true"></i>';
            } else {
                passwordInput.type = "password";
                togglePassword.innerHTML = '<i class="fa fa-eye-slash" aria-hidden="true"></i>';
            }
        });
    });


    document.addEventListener("DOMContentLoaded", function () {
        const passwordInput = document.getElementById("log-password");
        const togglePassword = document.querySelector(".log-password-cls");

        togglePassword.addEventListener("click", function () {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                togglePassword.innerHTML = '<i class="fa fa-eye" aria-hidden="true"></i>';
            } else {
                passwordInput.type = "password";
                togglePassword.innerHTML = '<i class="fa fa-eye-slash" aria-hidden="true"></i>';
            }
        });
    });


    document.addEventListener("DOMContentLoaded", function() {
        var loginTabLink = document.getElementById("loginTabLink");
        var isSignup = <?php echo isset($_GET['is_signup']) && $_GET['is_signup'] == 1 ? "true" : "false"; ?>;
        var tab0 = document.getElementById("tab0");
        var tab1 = document.getElementById("tab1");

        if (isSignup) {
             loginTabLink.classList.remove("active");

        }

        if (isSignup) {
            loginTabLink.classList.add("play");

        }

        document.addEventListener("click", function(event) {
            if (event.target.classList.contains("play")) {
                tab0.classList.remove("force-display-none");
                tab1.classList.remove("force-display-block");
            }
        });
    });

  
</script>