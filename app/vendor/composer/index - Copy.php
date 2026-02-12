<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

get_header();
?>

<link href="<?=get_template_directory_uri()?>/content/styles.css" rel="stylesheet" />

    <nav id="nav-menu-container2">
        <ul class="nav-menu">
            <li class="menu-active"><a href="#intro"><i class="fa fa-circle" aria-hidden="true"></i></a></li>
            <li><a href="#services-content"><i class="fa fa-circle" aria-hidden="true"></i></a></li>
            <li><a href="#people-content"><i class="fa fa-circle" aria-hidden="true"></i></a></li>
            <li><a href="#testimonials-content"><i class="fa fa-circle" aria-hidden="true"></i></a></li>
        </ul>
    </nav>



    <!--==========================
	  Intro Section
	============================-->
    <section id="intro">
        <div class="intro-container">
            <div id="introCarousel" class="carousel  slide carousel-fade" data-ride="carousel">

                <!--<ol class="carousel-indicators"></ol>-->

                <div class="carousel-inner" role="listbox">

                    <?php
                    $topBanner = get_field('top_banner',2);
                    $sr = 0;
                    foreach ($topBanner as $banner) {
	                    ?>

                        <div class="carousel-item <?php echo $sr == 0 ? 'active' : '';?>">
                            <div class="carousel-background"><img
                                        src="<?=$banner['image']?>" alt=""></div>
                            <div class="carousel-container">
                                <div class="carousel-content">
                                    <h2><?=$banner['title']?> </h2>
                                    <a href="<?=$banner['link']?>" class="btn-get-started scrollto"><?=$banner['link_title']?></a>
                                </div>
                            </div>
                        </div>
	                    <?php
	                    $sr++;
                        }
                        ?>

                </div>

                <a class="carousel-control-prev" href="#introCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon ion-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>

                <a class="carousel-control-next" href="#introCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon ion-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>

            </div>
        </div>


        <a class="arrow-down" href="#services-content"><!--<img src="<?=get_template_directory_uri()?>/img/downarrow.png" alt="Arrow"/>--><i class="fa fa-angle-down" aria-hidden="true"></i></a>

    </section><!-- #intro -->

    <main id="main">


        <section id="services-content">


            <div class="index-services-content">
                <div class="container">
                    <h2>SERVICES</h2>
                    <h1>We produce results</h1>
                    <p>We bring a combination of deep industry
                        knowledge and expert perspectives which keep our clients moving ahead during challenging
                        times.</p>
                    <ul>
                        <li><a href="<?=get_permalink(23)?>"><span>Practices</span><br/>Learn about the breadth of our industry experience</a></li>
                        <li><a href="<?=get_permalink(25)?>"><span>Industries</span><br/>Explore how we deliver results for our clients</a></li>
                    </ul>
                </div>
            </div>



            <a class="arrow-down" href="#people-content"><!--<img src="<?=get_template_directory_uri()?>/img/downarrow.png" alt="Arrow"/>--><i class="fa fa-angle-down" aria-hidden="true"></i></a>

        </section>



        <section id="people-content" class="home-people">


            <div class="index-services-content people-content">
                <div class="container">
                    <h2>People</h2>
                    <h1>Looking for a specific lawyer?</h1>
                    <p>Our qualified teams comprise of locally qualified Emirati and International lawyers, who have worked in advanced economies, supporting clients with a wide variety of legal challenges.</p>

                    <div class="search-container">
                        <form action="<?=site_url()?>/people/people-search/" method="get">
                            <input type="text" placeholder="Search.." name="searchkey" id="autocomplete">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>

                    <a href="<?=get_permalink(31)?>" class="btn-get-started scrollto">View all lawyers</a>

                </div>
            </div>

            <a class="arrow-down" href="#testimonials-content"><!--<img src="<?=get_template_directory_uri()?>/img/downarrow.png" alt="Arrow"/>--><i class="fa fa-angle-down" aria-hidden="true"></i></a>

        </section>


        <section id="testimonials-content">
            <div class="index-services-content people-content">
                <div class="container">
                    <!--<h2>Testimonials</h2>-->
                    <h1>What our people say</h1>


                    <div class="owl-carousel testimonials-carousel">

                        <div class="testimonial-item">

                            <p>
                                <img src="<?=get_template_directory_uri()?>/img/quote-sign-left.png" class="quote-sign-left" alt="">
                                I am fortunate enough to have recently joined one of the leading litigation law firms in the UAE, Galadari Advocates & Legal Consultants. It is exciting to be part of Galadari’s push to become market leaders in other practice areas. 

                            <h4>DEAN O’LEARY, PARTNER – HEAD OF CONSTRUCTION & INFRASTRUCTURE</h4>
                            </p>
                        </div>


                        <div class="testimonial-item">

                            <p>
                                <img src="<?=get_template_directory_uri()?>/img/quote-sign-left.png" class="quote-sign-left" alt="">
                                Since I joined the firm over two years ago, I have been given the opportunity to work across various sectors and practice groups. The flexibility I found at Galadari has been a unique opportunity for me and other entry level professionals, helping us kick start our career and feeding our ambition.
                            <h4>ARSHIYA MUNIR, PARALEGAL</h4>
                            </p>
                        </div>


                        <div class="testimonial-item">

                            <p>
                                <img src="<?=get_template_directory_uri()?>/img/quote-sign-left.png" class="quote-sign-left" alt="">
                                The firm carries the same essence as the country of synergising the best of several nationalities and creating an enhanced output.
                            <h4>RAKA ROY, SENIOR COUNSEL – INTELLECTUAL PROPERTY</h4>
                            </p>
                        </div>

                        <div class="testimonial-item">

                            <p>
                                <img src="<?=get_template_directory_uri()?>/img/quote-sign-left.png" class="quote-sign-left" alt="">
                                The diversity of the clientele and lawyers at Galadari is an indication of its progressiveness and success as a prominent local law firm since 1983. My experience to date has encompassed unequivocal growth and exposure as a result of these factors.
                            <h4>FADI HASSOUN, PARTNER – HEAD OF THE ABU DHABI OFFICE</h4>
                            </p>
                        </div>

                        <div class="testimonial-item">

                            <p>
                                <img src="<?=get_template_directory_uri()?>/img/quote-sign-left.png" class="quote-sign-left" alt="">
                                Having worked for several international law firms in the UAE and Europe, I knew that joining a regional entity would be a great challenge, allowing me to contribute to the business as much as I would learn from it.
                            <h4>JEANNE-SOPHIE NIARD, BUSINESS DEVELOPMENT MANAGER</h4>
                            </p>
                        </div>
<div class="testimonial-item">

                            <p>
                                <img src="<?=get_template_directory_uri()?>/img/quote-sign-left.png" class="quote-sign-left" alt="">
                                Testing new
                            <h4>faizan</h4>
                            </p>
                        </div>



                    </div>




                </div>
            </div>

            <a class="arrow-down" href="#intro"><!--<img src="<?=get_template_directory_uri()?>/img/downarrow.png" alt="Arrow"/>--><i class="fa fa-angle-up" aria-hidden="true"></i></a>
        </section>

    </main>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script type="text/javascript" src="<?=get_template_directory_uri()?>/scripts/jquery.mockjax.js"></script>
    <script type="text/javascript" src="<?=get_template_directory_uri()?>/src/jquery.autocomplete.js"></script>



<script>
    


        var lawyers = {"Ziad Galadari":"Ziad Galadari","Ahmed Galadari":"Ahmed Galadari","Abdulla Ziad Galadari ":"Abdulla Ziad Galadari ","Dean O\u2019Leary":"Dean O\u2019Leary","Mojahed Al Sebae":"Mojahed Al Sebae","Ken Dixon":"Ken Dixon","Fadi Hassoun":"Fadi Hassoun","Peter J Bowring ":"Peter J Bowring ","Marwan Al Cherkeh":"Marwan Al Cherkeh","Hassan Tawakalna":"Hassan Tawakalna","Manish Narayan":"Manish Narayan","Raka Roy":"Raka Roy","Stephen Ballantine":"Stephen Ballantine","Mohammad Abdul Rahman ":"Mohammad Abdul Rahman ","Abdul Hameed Beltagi":"Abdul Hameed Beltagi","Aboubkar Ramadan ":"Aboubkar Ramadan ","Aeeda Ibrahim ":"Aeeda Ibrahim ","Ahmed Kamel Salman Attia":"Ahmed Kamel Salman Attia","Ahmed Yehia Ali Mohamed ":"Ahmed Yehia Ali Mohamed ","Ahmed Ziad Galadari":"Ahmed Ziad Galadari","Anwar Wadidi":"Anwar Wadidi","Arshiya Munir":"Arshiya Munir","Daniel Brawn":"Daniel Brawn","Ebrahim Mohammed Abdulla Al Tenaiji":"Ebrahim Mohammed Abdulla Al Tenaiji","Emad El Habbak":"Emad El Habbak","Essa Ziad Galadari":"Essa Ziad Galadari","Fadh Nazeer":"Fadh Nazeer","Gerry Rogers":"Gerry Rogers","Hadeel Mohamed ":"Hadeel Mohamed ","Haitham Jbour":"Haitham Jbour","Hussein Demerdash ":"Hussein Demerdash ","Hussein Shawky":"Hussein Shawky","Iqbal Lala":"Iqbal Lala","Islam Hassan Ali Oraif ":"Islam Hassan Ali Oraif ","Leopold Thanickal Jose ":"Leopold Thanickal Jose ","Magdi Osman":"Magdi Osman","Mahmood Shakir Al Mashhadani ":"Mahmood Shakir Al Mashhadani ","Maria Palmou":"Maria Palmou","Mariane Iskander":"Mariane Iskander","Mohamed Salem Koura":"Mohamed Salem Koura","Mostafa Shehata ":"Mostafa Shehata ","Muhammad Mustafa Khalid":"Muhammad Mustafa Khalid","Omar Kayal":"Omar Kayal","Paula Villegas Guevara":"Paula Villegas Guevara","Rachel Dixon":"Rachel Dixon","Ramy Hesham ":"Ramy Hesham ","Rashed Al Sumaity ":"Rashed Al Sumaity ","Saleh Mohd Sayed":"Saleh Mohd Sayed","Shani Salim ":"Shani Salim ","Taha Ramadan":"Taha Ramadan","Wael Taha":"Wael Taha","Waleed Al Kholy":"Waleed Al Kholy","Youssef Aly":"Youssef Aly","Youssef Khalaf ":"Youssef Khalaf "};

        var countriesArray = $.map(lawyers, function (value, key) { return { value: value, data: key }; });

    // Initialize autocomplete with custom appendTo:
    $('#autocomplete').autocomplete({
        lookup: countriesArray,
        onSelect: function () {
            var searchVal = $('#autocomplete').val();

            $('#result').html('<div style="text-align:center;width: 100%;"><img src="https://www.acumenadagency.com/website/wp-galadari/loader.gif" /></div>');

            //alert(practice);

            $.mockjaxClear();

            $.ajax({
                method: "POST",
                url: "https://www.acumenadagency.com/website/wp-galadari/search.php",
                data: { searchVal: searchVal}
            })
                .done(function( result ) {
                    //alert(result);
                    $('#result').html(result);
                });
        }
    });


    $(document).ready(function () {
        $('#searchbtn').on('click',function () {

            var searchVal = $('#autocomplete').val();

            $('#result').html('<div style="text-align:center;width: 100%;"><img src="https://www.acumenadagency.com/website/wp-galadari/loader.gif" /></div>');

            $.mockjaxClear();

            $.ajax({
                method: "POST",
                url: "https://www.acumenadagency.com/website/wp-galadari/search.php",
                data: { searchVal: searchVal}
            })
                .done(function( result ) {
                    //alert(result);
                    $('#result').html(result);
                });
        })
    });

    function onwindowLoadSearch() {
        var searchVal = $('#autocomplete').val();

        $('#result').html('<div style="text-align:center;width: 100%;"><img src="https://www.acumenadagency.com/website/wp-galadari/loader.gif" /></div>');

        $.mockjaxClear();

        $.ajax({
            method: "POST",
            url: "https://www.acumenadagency.com/website/wp-galadari/search.php",
            data: { searchVal: searchVal}
        })
            .done(function( result ) {
                //alert(result);
                $('#result').html(result);
            });
    }



</script>

<?php
get_footer();
