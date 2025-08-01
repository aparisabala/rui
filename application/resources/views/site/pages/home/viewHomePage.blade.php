@extends('site.layout.main_layout',["tabTitle" => config('i.service_name')." | Welcome " ])
@section('page')
<!-- Slider Area Start Here -->
<div class="slider-area slider-content-center slider-overlay">
    <div class="bend niceties preview-1">
        <div id="ensign-nivoslider-3" class="slides">
            <img src="img/slider/slide2_1.jpg" alt="slider" title="#slider-direction-1" />
            <img src="img/slider/slide2_2.jpg" alt="slider" title="#slider-direction-2" />
            <img src="img/slider/slide2_3.jpg" alt="slider" title="#slider-direction-3" />
        </div>
        <div id="slider-direction-1" class="t-cn slider-direction">
            <div class="slider-content s-tb slide-2">
                <div class="title-container s-tb-c">
                    <div class="container">
                        <div class="large-upper-title">Find A Good Accountant</div>
                        <p>We look Forward To Getting to know you and to helipng you take your business to new heights!</p>
                        <div class="slider-btn-area">
                            <a href="#" class="btn-fill-round">Our Serices<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="slider-direction-2" class="t-cn slider-direction">
            <div class="slider-content s-tb slide-2">
                <div class="title-container s-tb-c">
                    <div class="container">
                        <div class="large-upper-title">Financial Advisore Here</div>
                        <p>We look Forward To Getting to know you and to helipng you take your business to new heights!</p>
                        <div class="slider-btn-area">
                            <a href="#" class="btn-fill-round">Our Serices<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="slider-direction-3" class="t-cn slider-direction">
            <div class="slider-content s-tb slide-2">
                <div class="title-container s-tb-c">
                    <div class="container">
                        <div class="large-upper-title">Find A Good Accountant</div>
                        <p>We look Forward To Getting to know you and to helipng you take your business to new heights!</p>
                        <div class="slider-btn-area">
                            <a href="#" class="btn-fill-round">Our Serices<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Slider Area End Here -->
<!-- Left Tab Start Here -->
<div class="left-tab-style">
    <div class="container">
        <!-- tabs left -->
        <div class="tabbable tabs-left">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#financial" data-toggle="tab"><i class="flaticon-rich"></i>Financial Planning</a></li>
                <li><a href="#tax" data-toggle="tab"><i class="flaticon-notes"></i>TAX Solution</a></li>
                <li><a href="#research" data-toggle="tab"><i class="flaticon-chart"></i>Market Research</a></li>
                <li><a href="#mutual" data-toggle="tab"><i class="flaticon-graph"></i>Mutual Funds</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="financial">
                    <h2>Financial Planning</h2>
                    <p>Bimply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised</p>
                    <p>Bimply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                </div>
                <div class="tab-pane" id="tax">
                    <h2>TAX Solution</h2>
                    <p>Bimply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised</p>
                    <p>Bimply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                </div>
                <div class="tab-pane" id="research">
                    <h2>Market Research</h2>
                    <p>Bimply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised</p>
                    <p>Bimply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                </div>
                <div class="tab-pane" id="mutual">
                    <h2>Mutual Funds</h2>
                    <p>Bimply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised</p>
                    <p>Bimply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                </div>
            </div>
        </div>
        <!-- /tabs -->
    </div>
</div>
<!-- Left Tab End Here -->
<!-- People Choose Services Start here -->
<div class="people-choose-services">
    <span class="banner-logo"><img class="img-responsive" src="img/banner-logo.png" alt="banner-logo"></span>
    <div class="choose-services">
        <div class="choose-services-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="people-choose-content">
                            <h2>Why People Choose Our Services?</h2>
                            <p>Bimply dummy text of the printing and typesetting industry orem Ipsum deartyhas been the industry's standard dummy text ever since thewhengalley of type.</p>
                            <a class="ghost-btn" href="#">Read More<i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="people-image"><img class="img-responsive" src="img/section9.jpg" alt="section9"></div>
</div>
<!-- People Choose Services End here -->
<!-- Feature Service Start Here -->
<div class="service-two-area">
    <div class="container">
        <div class="row">
            <div class="section-title section-title-center">
                <h2>Featured Services</h2>
                <p>Fimply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standardever since unknown printer took a galley.</p>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="single-service">
                    <div class="item-icon pull-left"><i class="flaticon-money-1"></i></div>
                    <div class="item-content media-body">
                        <h3><a href="#">Investment Plan</a></h3>
                        <p>Rimply dummy text printinertg and type setting industryy's standard dumr since printer took a galley.</p>
                    </div>
                </div>
                <div class="single-service">
                    <div class="item-icon pull-left"><i class="flaticon-open-book"></i></div>
                    <div class="item-content media-body">
                        <h3><a href="#">Education Loan</a></h3>
                        <p>Rimply dummy text printinertg and type setting industryy's standard dumr since printer took a galley.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="single-service">
                    <div class="item-icon pull-left"><i class="flaticon-avatar"></i></div>
                    <div class="item-content media-body">
                        <h3><a href="#">Retirement Policy</a></h3>
                        <p>Rimply dummy text printinertg and type setting industryy's standard dumr since printer took a galley.</p>
                    </div>
                </div>
                <div class="single-service">
                    <div class="item-icon pull-left"><i class="flaticon-get-money"></i></div>
                    <div class="item-content media-body">
                        <h3><a href="#">Tax Planning</a></h3>
                        <p>Rimply dummy text printinertg and type setting industryy's standard dumr since printer took a galley.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="single-service">
                    <div class="item-icon pull-left"><i class="flaticon-notes"></i></div>
                    <div class="item-content media-body">
                        <h3><a href="#">Mutual Fund</a></h3>
                        <p>Rimply dummy text printinertg and type setting industryy's standard dumr since printer took a galley.</p>
                    </div>
                </div>
                <div class="single-service">
                    <div class="item-icon pull-left"><i class="flaticon-atomic"></i></div>
                    <div class="item-content media-body">
                        <h3><a href="#">Comodities Trading</a></h3>
                        <p>Rimply dummy text printinertg and type setting industryy's standard dumr since printer took a galley.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Feature Service End Here -->
<!-- Counter Section Start Here -->
<div class="counter-area overlay-dark" style="background-image: url('img/section5.jpg');">
    <div class="container">
        <div class="counter-title">
            <h2>We are always ahead. <br>Professional Solutions for Your Business.</h2>
        </div>
        <div class="row">
            <div class="counter-content">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 counter1-box wow fadeInDown" data-wow-duration=".5s" data-wow-delay=".20s">
                    <h3 class="counter" data-num="1520">1520</h3>
                    <p>All Employees</p>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 counter1-box wow fadeInDown" data-wow-duration=".5s" data-wow-delay=".40s">
                    <h3 class="counter" data-num="1160">1160</h3>
                    <p>Happy Clients</p>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 counter1-box wow fadeInDown" data-wow-duration=".5s" data-wow-delay=".60s">
                    <h3 class="counter" data-num="1905">1905</h3>
                    <p>Satisfaction</p>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 counter1-box wow fadeInDown" data-wow-duration=".5s" data-wow-delay=".80s">
                    <h3 class="counter" data-num="1440">1440</h3>
                    <p>Cases completed</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Counter Section End Here -->
<!-- Expert Advisor Start Here -->
<div class="our-expert-advisor">
    <div class="container">
        <div class="section-title section-title-center">
            <h2>Our Expert Advisors</h2>
            <p>Fimply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standardever since unknown printer took a galley.</p>
        </div>
        <div class="fn-carousel arrow-left-right" data-loop="true" data-items="1" data-margin="0" data-autoplay="false" data-autoplay-timeout="10000" data-smart-speed="2000" data-dots="false" data-nav="true" data-nav-speed="false" data-r-x-small="1" data-r-x-small-nav="false" data-r-x-small-dots="true" data-r-x-medium="1" data-r-x-medium-nav="false" data-r-x-medium-dots="true" data-r-small="1" data-r-small-nav="false" data-r-small-dots="true" data-r-medium="1" data-r-medium-nav="true" data-r-medium-dots="false">
            <div class="single-expert">
                <div class="item-image"><img class="img-responsive" src="img/team/team2_1.jpg" alt="team"></div>
                <div class="item-content">
                    <h3>Mike Hussy</h3>
                    <span class="position">Project Manager</span>
                    <p>Dorem ipsum dolor sit. Incidunt laborum beata earum nihil odio consequatur officiis temporea consequuntur officia.</p>
                    <ul class="social-icons">
                        <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="single-expert">
                <div class="item-image"><img class="img-responsive" src="img/team/team2_1.jpg" alt="team"></div>
                <div class="item-content">
                    <h3>Mike Hussy</h3>
                    <span class="position">Co-Founder</span>
                    <p>Dorem ipsum dolor sit. Incidunt laborum beata earum nihil odio consequatur officiis temporea consequuntur officia.</p>
                    <ul class="social-icons">
                        <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Expert Advisor End Here -->
<!-- Financial Analysis Start Here -->
<div class="financial-analysis-area bg-accent">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="financial-content">
                    <h2>Financial Analysis</h2>
                    <p>Perspiciatis unde omnis iste natus sit voluptatem accusantium dremque laudansimply dummy text of the printing and typesetting istry. Lorem Ipsum has been the industry's standard dummy text ever sin, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronictsimply dummy printing.mmy text of the printing and typesetting istry.</p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="financial-graph">
                    <img class="img-responsive" src="img/graph3.png" alt="graph3">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Financial Analysis End Here -->
<!-- Banner One Start Here -->
<div class="banner-one-area">
    <div class="container">
        <div class="banner-content">
            <h2><span>To help entrepreneurs get their act together</span> before they talk to investors.</h2>
        </div>
    </div>
</div>
<!-- Banner One End Here -->
<!-- Our Case Studies Start Here -->
<div class="our-case-studies-area">
    <div class="container">
        <div class="section-title section-title-center">
            <h2>Our Case Studies</h2>
            <p>Fimply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standardever since unknown printer took a galley.</p>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="case-item">
                    <div class="item-image">
                        <img class="img-responsive" src="img/casestudies/case1.jpg" alt="case1">
                    </div>
                    <div class="item-content-bottom">
                        <h3><a href="#">Investment Planning</a></h3>
                        <p>Rmply dummy text of the printing and typeseting industry. Lorem Ipsum has been the dustry'dard dummy text ever since thhen an uknown printer took a galley and scrambled.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="case-item">
                    <div class="item-image item-image-mobile">
                        <img class="img-responsive" src="img/casestudies/case2.jpg" alt="case1">
                    </div>
                    <div class="item-content-top">
                        <h3><a href="#">Business Loan</a></h3>
                        <p>Rmply dummy text of the printing and typeseting industry. Lorem Ipsum has been the dustry'dard dummy text ever since thhen an uknown printer took a galley and scrambled.</p>
                    </div>
                    <div class="item-image item-image-desktop">
                        <img class="img-responsive" src="img/casestudies/case2.jpg" alt="case1">
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="case-item">
                    <div class="item-image">
                        <img class="img-responsive" src="img/casestudies/case3.jpg" alt="case1">
                    </div>
                    <div class="item-content-bottom">
                        <h3><a href="#">Money Transfers</a></h3>
                        <p>Rmply dummy text of the printing and typeseting industry. Lorem Ipsum has been the dustry'dard dummy text ever since thhen an uknown printer took a galley and scrambled.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Our Case Studies End Here -->
<!-- Request Call Back Start Here -->
<div class="request-call-two-area">
    <div class="request-image"><img class="img-responsive" src="img/section10.jpg" alt="section9"></div>
    <div class="request-form-wrapper">
        <div class="request-form">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="request-title">
                            <h2>Request a Call Back</h2>
                        </div>
                        <form id="request-form" class="request-form-select">
                            <fieldset>
                                <div class="form-group">
                                    <input type="text" placeholder="Name*" class="form-control" name="name" id="form-name" data-error="Name field is required" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <input type="email" placeholder="Email*" class="form-control" name="email" id="form-email" data-error="Email field is required" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <input type="text" placeholder="Phone*" class="form-control" name="phone" id="form-phone" data-error="Phone field is required" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <input type="text" placeholder="I Would Like To Discuss" class="form-control" name="select" id="form-select">
                                </div>
                                <div class="form-group margin-bottom-none">
                                    <button type="submit" class="default-big-btn">Submit</button>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
                                    <div class='form-response'></div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Request Call Back End Here -->
<!-- Our Partners Start Here -->
<div class="our-partner">
    <div class="container">
        <div class="fn-carousel nav-control-middle" data-loop="true" data-items="5" data-margin="30" data-autoplay="false" data-autoplay-timeout="10000" data-smart-speed="2000" data-dots="false" data-nav="true" data-nav-speed="false" data-r-x-small="2" data-r-x-small-nav="false" data-r-x-small-dots="true" data-r-x-medium="2" data-r-x-medium-nav="false" data-r-x-medium-dots="true" data-r-small="3" data-r-small-nav="true" data-r-small-dots="false" data-r-medium="5" data-r-medium-nav="true" data-r-medium-dots="false">
            <div class="single-item">
                <div class="item-image">
                    <a href="#"><img class="image-responsive" src="img/partner/audiojungle.png" alt="audiojungle"></a>
                </div>
            </div>
            <div class="single-item">
                <div class="item-image">
                    <a href="#"><img class="image-responsive" src="img/partner/codecanyon.png" alt="codecanyon"></a>
                </div>
            </div>
            <div class="single-item">
                <div class="item-image">
                    <a href="#"><img class="image-responsive" src="img/partner/graphicriver.png" alt="graphicriver"></a>
                </div>
            </div>
            <div class="single-item">
                <div class="item-image">
                    <a href="#"><img class="image-responsive" src="img/partner/photodune.png" alt="photodune"></a>
                </div>
            </div>
            <div class="single-item">
                <div class="item-image">
                    <a href="#"><img class="image-responsive" src="img/partner/videohive.png" alt="videohive"></a>
                </div>
            </div>
            <div class="single-item">
                <div class="item-image">
                    <a href="#"><img class="image-responsive" src="img/partner/audiojungle.png" alt="audiojungle"></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Our Partners End Here -->
@endsection