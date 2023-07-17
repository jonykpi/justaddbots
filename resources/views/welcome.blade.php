
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">

    <title>Your AI-Assistant
        for website support</title>
    <meta name="title" value="This AI employee is trained on your business knowledge base.">

    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Use Ai bot build as an employee to support your team, like ChatGPT, an intelligent AI assistant." />
    <meta property="og:description" content="Use Ai bot build as an employee to support your team, like ChatGPT, an intelligent AI assistant." />
    <meta property="og:url" content="https://aibotbuild.com/" />
    <meta property="og:site_name" content="Use Ai bot build as an employee to support your team, like ChatGPT, an intelligent AI assistant." />
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('icons/favicon.png')}}">
    <meta property="og:image" content="{{asset('icons/logo-color.png')}}" />
    <meta name="twitter:card" content="summary_large_image" />

    <!-- Bootstrap core CSS -->
    <link href="{{asset('frontend')}}/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('frontend')}}/custom.css" rel="stylesheet">

    <!--

    TemplateMo 570 Chain App Dev

    https://templatemo.com/tm-570-chain-app-dev

    -->

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('frontend')}}/assets/css/templatemo-chain-app-dev.css">
    <link rel="stylesheet" href="{{asset('frontend')}}/assets/css/animated.css">
    <link rel="stylesheet" href="{{asset('frontend')}}/assets/css/owl.css">

</head>

<body>

<!-- ***** Preloader Start ***** -->
<div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
        <span class="dot"></span>
        <div class="dots">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</div>
<!-- ***** Preloader End ***** -->

<!-- ***** Header Area Start ***** -->
<header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="{{url('/')}}" class="logo">
                        <img class="header_logo" src="{{asset('icons/logo_.png')}}" alt="Chain App Dev">
                    </a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                        <li class="scroll-to-section"><a href="{{url('/')}}#top" class="active">Home</a></li>
                        <li class="scroll-to-section"><a href="{{url('/')}}#services">Services</a></li>
                        <li class="scroll-to-section"><a href="{{url('/')}}#about-us">About support assistant?</a></li>
                        <li class="scroll-to-section"><a href="{{url('/')}}#pricing">Pricing</a></li>
                        <li class="scroll-to-section"><a href="{{url('/')}}#newsletter">Newsletter</a></li>
                        <li><div class="gradient-button">
                                @if(!Auth::guest())
                                    <a href="{{url(config('filament')['path'])}}"><i class="fa fa-sign-in-alt"></i> Dashboard </a>
                                @else
                                    <a id="" href="{{route('login')}}"><i class="fa fa-sign-in-alt"></i> Sign In Now</a>
                                @endif

                            </div></li>
                    </ul>
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
</header>
<!-- ***** Header Area End ***** -->


<div class="main-banner wow fadeIn" id="top" data-wow-duration="1s" data-wow-delay="0.5s">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6 align-self-center">
                        <div class="left-content show-up header-text wow fadeInLeft" data-wow-duration="1s" data-wow-delay="1s">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h2>Your AI-Assistant
                                        for website support</h2>
                                    <p>Experience personalized support with our Support Assistant Website, integrating vector data for tailored assistance.</p>
                                </div>
                                <div class="col-lg-12">
                                    <div class="white-button first-button scroll-to-section">

                                        @if(!Auth::guest())
                                            <a href="{{url(config('filament')['path'])}}"> <h5>Dashboard</h5> </a>
                                        @else
                                            <a href="{{route('login')}}"> <h5>Get started</h5> </a>
                                        @endif

                                        <br>
                                        <br>
                                        <b>No Credit Card Required</b>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="right-image wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.5s">
{{--                            <img src="{{asset('frontend')}}/assets/images/slider-dec.png" alt="">--}}
                            <img src="{{asset('frontend/poster/poster_1.png')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="services" class="services section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="section-heading  wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.5s">
                    <h4>AI Chat Bot </em> Templates</h4>
                    <img src="{{asset('frontend')}}/assets/images/heading-line-dec.png" alt="">
                    <p>Explore our extensive collection of AI Chatbot Templates, meticulously crafted to cater to a wide array of industries and use cases. These carefully curated templates are designed to expedite the process of creating the ideal bot for your team and customers. With our diverse range of options, you can jumpstart the development of a chatbot that perfectly aligns with your specific requirements. Whether you're seeking to enhance internal operations or enrich customer interactions, our selection of templates empowers you to effortlessly build a bot that meets your unique needs.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="service-item first-service">
                    <div class="icon"></div>
                    <h4>Enhancing Sales Performance with AI Assistance</h4>
                    <p>As an AI assistant, your goal is to improve sales performance by leveraging the power of artificial intelligence. AI can provide valuable insights, automate repetitive tasks, and optimize sales processes to drive efficiency and effectiveness. By employing AI techniques, you can enhance customer interactions, streamline lead management, and ultimately increase revenue.</p>

                </div>
            </div>


            <div class="col-lg-6">
                <div class="service-item fourth-service">
                    <div class="icon"></div>
                    <h4>24/7 Help &amp; Support</h4>
                    <p>As an AI assistant, your objective is to deliver round-the-clock customer support to enhance customer satisfaction and loyalty. With the help of artificial intelligence, you can offer timely and efficient assistance, resolve queries, and address customer concerns, even outside of regular business hours. Here's how AI can support your goal of providing 24/7 customer support.</p>

                </div>
            </div>
        </div>
    </div>
</div>

<div id="about-us" class="about-us section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 align-self-center">
                <div class="section-heading">
                    <h4>About <em>What We Do</em> &amp; Who We Are</h4>
                    <img src="{{asset('frontend')}}/assets/images/heading-line-dec.png" alt="">
                    <p>Ai bot build serves as a highly advanced AI assistant, akin to ChatGPT, but with the unique advantage of being trainable using your business-specific information, team dynamics, operational workflows, and client interactions. By leveraging your own knowledge base, Ai bot build seamlessly integrates into your workforce, functioning as an invaluable employee. Its capabilities encompass providing comprehensive support to your team, addressing inquiries, facilitating creative endeavors, resolving problems, and fostering ideation sessions. Ai bot build acts as an all-encompassing resource, empowering your organization to thrive.</p>
                </div>

            </div>
            <div class="col-lg-6">
                <div class="right-image">
                    <img src="{{asset('frontend/poster/paster_2.png')}}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>

{{--<div id="clients" class="the-clients">--}}
{{--    <div class="container">--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-8 offset-lg-2">--}}
{{--                <div class="section-heading">--}}
{{--                    <h4>Check What <em>The Clients Say</em> About Our App Dev</h4>--}}
{{--                    <img src="{{asset('frontend')}}/assets/images/heading-line-dec.png" alt="">--}}
{{--                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eismod tempor incididunt ut labore et dolore magna.</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-lg-12">--}}
{{--                <div class="naccs">--}}
{{--                    <div class="grid">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-lg-7 align-self-center">--}}
{{--                                <div class="menu">--}}
{{--                                    <div class="first-thumb active">--}}
{{--                                        <div class="thumb">--}}
{{--                                            <div class="row">--}}
{{--                                                <div class="col-lg-4 col-sm-4 col-12">--}}
{{--                                                    <h4>David Martino Co</h4>--}}
{{--                                                    <span class="date">30 November 2021</span>--}}
{{--                                                </div>--}}
{{--                                                <div class="col-lg-4 col-sm-4 d-none d-sm-block">--}}
{{--                                                    <span class="category">Financial Apps</span>--}}
{{--                                                </div>--}}
{{--                                                <div class="col-lg-4 col-sm-4 col-12">--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <span class="rating">4.8</span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div>--}}
{{--                                        <div class="thumb">--}}
{{--                                            <div class="row">--}}
{{--                                                <div class="col-lg-4 col-sm-4 col-12">--}}
{{--                                                    <h4>Jake Harris Nyo</h4>--}}
{{--                                                    <span class="date">29 November 2021</span>--}}
{{--                                                </div>--}}
{{--                                                <div class="col-lg-4 col-sm-4 d-none d-sm-block">--}}
{{--                                                    <span class="category">Digital Business</span>--}}
{{--                                                </div>--}}
{{--                                                <div class="col-lg-4 col-sm-4 col-12">--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <span class="rating">4.5</span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div>--}}
{{--                                        <div class="thumb">--}}
{{--                                            <div class="row">--}}
{{--                                                <div class="col-lg-4 col-sm-4 col-12">--}}
{{--                                                    <h4>May Catherina</h4>--}}
{{--                                                    <span class="date">27 November 2021</span>--}}
{{--                                                </div>--}}
{{--                                                <div class="col-lg-4 col-sm-4 d-none d-sm-block">--}}
{{--                                                    <span class="category">Business &amp; Economics</span>--}}
{{--                                                </div>--}}
{{--                                                <div class="col-lg-4 col-sm-4 col-12">--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <span class="rating">4.7</span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div>--}}
{{--                                        <div class="thumb">--}}
{{--                                            <div class="row">--}}
{{--                                                <div class="col-lg-4 col-sm-4 col-12">--}}
{{--                                                    <h4>Random User</h4>--}}
{{--                                                    <span class="date">24 November 2021</span>--}}
{{--                                                </div>--}}
{{--                                                <div class="col-lg-4 col-sm-4 d-none d-sm-block">--}}
{{--                                                    <span class="category">New App Ecosystem</span>--}}
{{--                                                </div>--}}
{{--                                                <div class="col-lg-4 col-sm-4 col-12">--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <span class="rating">3.9</span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="last-thumb">--}}
{{--                                        <div class="thumb">--}}
{{--                                            <div class="row">--}}
{{--                                                <div class="col-lg-4 col-sm-4 col-12">--}}
{{--                                                    <h4>Mark Amber Do</h4>--}}
{{--                                                    <span class="date">21 November 2021</span>--}}
{{--                                                </div>--}}
{{--                                                <div class="col-lg-4 col-sm-4 d-none d-sm-block">--}}
{{--                                                    <span class="category">Web Development</span>--}}
{{--                                                </div>--}}
{{--                                                <div class="col-lg-4 col-sm-4 col-12">--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <span class="rating">4.3</span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-lg-5">--}}
{{--                                <ul class="nacc">--}}
{{--                                    <li class="active">--}}
{{--                                        <div>--}}
{{--                                            <div class="thumb">--}}
{{--                                                <div class="row">--}}
{{--                                                    <div class="col-lg-12">--}}
{{--                                                        <div class="client-content">--}}
{{--                                                            <img src="{{asset('frontend')}}/assets/images/quote.png" alt="">--}}
{{--                                                            <p>“Lorem ipsum dolor sit amet, consectetur adpiscing elit, sed do eismod tempor idunte ut labore et dolore magna aliqua darwin kengan--}}
{{--                                                                lorem ipsum dolor sit amet, consectetur picing elit massive big blasta.”</p>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="down-content">--}}
{{--                                                            <img src="{{asset('frontend')}}/assets/images/client-image.jpg" alt="">--}}
{{--                                                            <div class="right-content">--}}
{{--                                                                <h4>David Martino</h4>--}}
{{--                                                                <span>CEO of David Company</span>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <div>--}}
{{--                                            <div class="thumb">--}}
{{--                                                <div class="row">--}}
{{--                                                    <div class="col-lg-12">--}}
{{--                                                        <div class="client-content">--}}
{{--                                                            <img src="{{asset('frontend')}}/assets/images/quote.png" alt="">--}}
{{--                                                            <p>“CTO, Lorem ipsum dolor sit amet, consectetur adpiscing elit, sed do eismod tempor idunte ut labore et dolore magna aliqua darwin kengan--}}
{{--                                                                lorem ipsum dolor sit amet, consectetur picing elit massive big blasta.”</p>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="down-content">--}}
{{--                                                            <img src="{{asset('frontend')}}/assets/images/client-image.jpg" alt="">--}}
{{--                                                            <div class="right-content">--}}
{{--                                                                <h4>Jake H. Nyo</h4>--}}
{{--                                                                <span>CTO of Digital Company</span>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <div>--}}
{{--                                            <div class="thumb">--}}
{{--                                                <div class="row">--}}
{{--                                                    <div class="col-lg-12">--}}
{{--                                                        <div class="client-content">--}}
{{--                                                            <img src="{{asset('frontend')}}/assets/images/quote.png" alt="">--}}
{{--                                                            <p>“May, Lorem ipsum dolor sit amet, consectetur adpiscing elit, sed do eismod tempor idunte ut labore et dolore magna aliqua darwin kengan--}}
{{--                                                                lorem ipsum dolor sit amet, consectetur picing elit massive big blasta.”</p>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="down-content">--}}
{{--                                                            <img src="{{asset('frontend')}}/assets/images/client-image.jpg" alt="">--}}
{{--                                                            <div class="right-content">--}}
{{--                                                                <h4>May C.</h4>--}}
{{--                                                                <span>Founder of Catherina Co.</span>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <div>--}}
{{--                                            <div class="thumb">--}}
{{--                                                <div class="row">--}}
{{--                                                    <div class="col-lg-12">--}}
{{--                                                        <div class="client-content">--}}
{{--                                                            <img src="{{asset('frontend')}}/assets/images/quote.png" alt="">--}}
{{--                                                            <p>“Lorem ipsum dolor sit amet, consectetur adpiscing elit, sed do eismod tempor idunte ut labore et dolore magna aliqua darwin kengan--}}
{{--                                                                lorem ipsum dolor sit amet, consectetur picing elit massive big blasta.”</p>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="down-content">--}}
{{--                                                            <img src="{{asset('frontend')}}/assets/images/client-image.jpg" alt="">--}}
{{--                                                            <div class="right-content">--}}
{{--                                                                <h4>Random Staff</h4>--}}
{{--                                                                <span>Manager, Digital Company</span>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <div>--}}
{{--                                            <div class="thumb">--}}
{{--                                                <div class="row">--}}
{{--                                                    <div class="col-lg-12">--}}
{{--                                                        <div class="client-content">--}}
{{--                                                            <img src="{{asset('frontend')}}/assets/images/quote.png" alt="">--}}
{{--                                                            <p>“Mark, Lorem ipsum dolor sit amet, consectetur adpiscing elit, sed do eismod tempor idunte ut labore et dolore magna aliqua darwin kengan--}}
{{--                                                                lorem ipsum dolor sit amet, consectetur picing elit massive big blasta.”</p>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="down-content">--}}
{{--                                                            <img src="{{asset('frontend')}}/assets/images/client-image.jpg" alt="">--}}
{{--                                                            <div class="right-content">--}}
{{--                                                                <h4>Mark Am</h4>--}}
{{--                                                                <span>CTO, Amber Do Company</span>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

<div id="pricing" class="pricing-tables">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="section-heading">
                    <h4>We Have The Best Pre-Order <em>Prices</em> You Can Get</h4>
                    <img src="{{asset('frontend')}}/assets/images/heading-line-dec.png" alt="">
                    <p>Whether you are utilizing ai support assistant for personal purposes, collaborating with a team, or intending to offer it to your clientele, we have a suitable package available for you.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="pricing-item-regular">
                    <span class="price">$12</span>
                    <h4>Basic</h4>
                    <div class="icon">
                        <img src="{{asset('frontend/poster/item_pr.png')}}" alt="">
                    </div>
                    <ul class="no-bullet custom-bullets">
                        <li>3000 <strong>GPT3.5 16K</strong> Queries/Mo</li>
                        <li>5 Users</li>
                        <li>2 Bots</li>
                        <li>1,000 Documents</li>
                        <li>Embed Website Widget</li>
                        <li>Customize Website Widget</li>
{{--                        <li>API</li>--}}
                    </ul>
                    <div class="border-button">
                        <a target="_blank" href="https://discord.gg/aCnzBJwf">Contact us</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="pricing-item-regular">
                    <span class="price">$25</span>
                    <h4>Golden</h4>
                    <div class="icon">
                        <img src="{{asset('frontend/poster/item_pr.png')}}" alt="">
                    </div>
                    <ul class="no-bullet custom-bullets">
                        <li>1,200 <strong>GPT4</strong> Queries/Mo</li>
                        <li>20 Users</li>
                        <li>15 Bots</li>
                        <li>10,000 Documents</li>
                        <li>10,000 Website Pages</li>
                        <li>Embed Website Widget (5 Websites)</li>
                        <li>Customize Website Widget</li>
                        {{--                        <li>API</li>--}}
                    </ul>

                                        <div class="border-button">
                                            <a target="_blank" href="https://discord.gg/aCnzBJwf">Contact us</a>
                                        </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="pricing-item-regular">
                    <span class="price">$66</span>
                    <h4>Advance</h4>
                    <div class="icon">
                        <img src="{{asset('frontend/poster/item_pr.png')}}" alt="">
                    </div>
                    <ul>
                        <li>1,200 <strong>GPT4</strong> Queries/Mo (or)</li>
                        <li>15,000 <strong>GPT3.5 16K Queries/Mo</strong></li>
                        <li>50 Users</li>
                        <li>50 Bots</li>
                        <li>25,000 Documents</li>
                        <li>25,000 Website Pages</li>
                        <li>Embed Website Widget (100 Websites)</li>
                        <li>Customize Website Widget</li>
                    </ul>
                    <div class="border-button">
                        <a target="_blank" href="https://discord.gg/aCnzBJwf">Contact us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer id="newsletter">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="section-heading">
                    <h4>Join our mailing list to receive the news &amp; latest trends</h4>
                </div>
            </div>
            <div class="col-lg-6 offset-lg-3">
                <form id="search" action="#" method="GET">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6">
                            <fieldset>
                                <input type="address" name="address" class="email" placeholder="Email Address..." autocomplete="on" required>
                            </fieldset>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <fieldset>
                                <button type="submit" class="main-button">Subscribe Now <i class="fa fa-angle-right"></i></button>
                            </fieldset>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="footer-widget">
                    <h4>Contact Us</h4>
                    <p><a href="mailto:support@aisupportassistant.com">support@aisupportassistant.com</a></p>
                    <a target="_blank" href="https://discord.com/invite/aCnzBJwf"><i class="fab fa-3x fa-discord"></i></a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="footer-widget">
                    <h4>About Us</h4>
                    <div class="flex _justify-space-between">
                        <ul>
                            <li><a href="#top">Home</a></li>
                            <li><a href="#services">Services</a></li>
                            <li><a href="#contact">Contact</a></li>
                        </ul>
                        <ul>
                            <li><a href="#newsletter">Newsletter</a></li>
                            <li><a href="#pricing">Pricing</a></li>
                            <li><a href="#about">About Support Assistant?</a></li>

                        </ul>
                    </div>

                </div>
            </div>

            <div class="col-lg-4">
                <div class="footer-widget">
                    <h4>About Our Company</h4>
                    <div class="logo">
                        <img class="" src="{{asset('icons/logo_.png')}}" alt="">
                    </div>
                    <p>Experience personalized support with our Support Assistant Website, integrating vector data for tailored assistanc</p>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="copyright-text">
                    <p>Copyright © {{\Carbon\Carbon::now()->format('Y')}} Ai bot build. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer>


<!-- Scripts -->
<script src="{{asset('frontend')}}/vendor/jquery/jquery.min.js"></script>
<script src="{{asset('frontend')}}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('frontend')}}/assets/js/owl-carousel.js"></script>
<script src="{{asset('frontend')}}/assets/js/animation.js"></script>
<script src="{{asset('frontend')}}/assets/js/imagesloaded.js"></script>
<script src="{{asset('frontend')}}/assets/js/popup.js"></script>
<script src="{{asset('frontend')}}/assets/js/custom.js"></script>
</body>
</html>
