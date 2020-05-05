

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">

        <title>普瑞教育</title>


        <!-- Bootstrap core CSS -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Favicons -->    
        <meta name="theme-color" content="#563d7c">
        <style>
            .carousel-fade .carousel-inner .carousel-item {
                -webkit-transform: translateX(0);
                transform: translateX(0);
                transition-property: opacity;
            }
            .carousel-fade .carousel-inner .carousel-item,
            .carousel-fade .carousel-inner .active.carousel-item-left,
            .carousel-fade .carousel-inner .active.carousel-item-right {
                opacity: 0;
            }
            .carousel-fade .carousel-inner .active,
            .carousel-fade .carousel-inner .carousel-item-next.carousel-item-left,
            .carousel-fade .carousel-inner .carousel-item-prev.carousel-item-right {
                opacity: 1;
            }

            .carousel-vertical .carousel-inner .carousel-item-next.carousel-item-left,
            .carousel-vertical .carousel-inner .carousel-item-prev.carousel-item-right {
                -webkit-transform: translateY(0);
                transform: translateY(0);
            }
            .carousel-vertical .carousel-inner .active.carousel-item-left,
            .carousel-vertical .carousel-inner .carousel-item-prev {
                -webkit-transform: translateY(-100%);
                transform: translateY(-100%);
            }
            .carousel-vertical .carousel-inner .active.carousel-item-right,
            .carousel-vertical .carousel-inner .carousel-item-next {
                -webkit-transform: translateY(100%);
                transform: translateY(100%);
            }
            .carousel-control-up{
                position: absolute;
                top: 0;
                z-index: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                color: #fff;
                text-align: center;
                opacity: 0.5;
                transition: opacity 0.15s ease;
            }
            .carousel-control-down{
                position: absolute;
                bottom: 0;
                z-index: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                color: #fff;
                text-align: center;
                opacity: 0.5;
                transition: opacity 0.15s ease;
            }
            .carousel-control-up-icon, .carousel-control-down-icon {
                display: inline-block;
                width: 100%;
                height: 20px;
                background: no-repeat 50%/100% 100%;
            }

        </style>

    </head>
    <body >
        <div id="slides" class="carousel slide carousel-vertical" data-ride="carousel">
            
               <a class="carousel-control-up" href="#slides" data-slide="prev">
                <span class="carousel-control-up-icon">up</span>
            </a>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="jumbotron bg-secondary">
                        dkad;kad;aksd;ald<br>
                        dkad;kad;aksd;ald<br>
                        dkad;kad;aksd;ald<br> 
                        dkad;kad;aksd;ald<br>
                        dkad;kad;aksd;ald<br>
                        dkad;kad;aksd;ald<br>
                        dkad;kad;aksd;ald<br>
                        dkad;kad;aksd;ald<br>
                        dkad;kad;aksd;ald<br>          
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="jumbotron bg-primary">
                        2
                        dkad;kad;aksd;ald<br>
                        dkad;kad;aksd;ald<br>
                        dkad;kad;aksd;ald<br> 
                        dkad;kad;aksd;ald<br>
                        dkad;kad;aksd;ald<br>
                        dkad;kad;aksd;ald<br>
                        dkad;kad;aksd;ald<br>
                        dkad;kad;aksd;ald<br>
                        dkad;kad;aksd;ald<br>     
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="jumbotron bg-primary">
                        3
                        dkad;kad;aksd;ald<br>
                        dkad;kad;aksd;ald<br>
                        dkad;kad;aksd;ald<br> 
                        dkad;kad;aksd;ald<br>
                        dkad;kad;aksd;ald<br>
                        dkad;kad;aksd;ald<br>
                        dkad;kad;aksd;ald<br>
                        dkad;kad;aksd;ald<br>
                        dkad;kad;aksd;ald<br>     
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="jumbotron bg-primary">
                        4
                        dkad;kad;aksd;ald<br>
                        dkad;kad;aksd;ald<br>
                        dkad;kad;aksd;ald<br> 
                        dkad;kad;aksd;ald<br>
                        dkad;kad;aksd;ald<br>
                        dkad;kad;aksd;ald<br>
                        dkad;kad;aksd;ald<br>
                        dkad;kad;aksd;ald<br>
                        dkad;kad;aksd;ald<br>     
                    </div>
                </div>
            </div>

         
            <a class="carousel-control-down" href="#slides" data-slide="next">
                <span class="carousel-control-down-icon">down</span>
            </a>
        </div>

        <!--        
                
                <div id="app" class="carousel slide" data-ride="carousel">
        
                    <div class="carousel-inner">
                        <div class="carousel-item active" data-interval="10000">
                            <div class="jumbotron bg-secondary">
                                dkad;kad;aksd;ald<br>
                                dkad;kad;aksd;ald<br>
                                dkad;kad;aksd;ald<br> 
                                dkad;kad;aksd;ald<br>
                                dkad;kad;aksd;ald<br>
                                dkad;kad;aksd;ald<br>
                                dkad;kad;aksd;ald<br>
                                dkad;kad;aksd;ald<br>
                                dkad;kad;aksd;ald<br>          
                            </div>
                        </div>
                        <div class="carousel-item" data-interval="2000">
                            <div class="jumbotron bg-primary">
                                2
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="jumbotron bg-info">
                                3
                            </div>
                        </div>
                    </div>
        
                    <a class="carousel-control-prev" href="#app" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#app" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
        -->


        <script src="{{ asset('js/app.js') }}" defer></script>
        <script>

        </script>
    </body>
</html>


