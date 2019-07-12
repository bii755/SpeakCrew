body {
       font-family: Lato, 'Helvetica Neue', Helvetica, Arial, sans-serif;
       color: #989898;
       margin: 10px;
       }
       .navfar {
   background-color: white;
   border-bottom: 1px solid #e6e6e6;
   -webkit-box-shadow: 0px 2px 10px 0px rgba(0, 0, 0, 0.12);
   box-shadow: 0px 2px 10px 0px rgba(0, 0, 0, 0.12);
}

.navbar {
   z-index: 16;
   position: fixed;
   top: 0;
       left: 0;
   right: 0;
   width: 100%;
   -webkit-transition: all .2s ease;
   -o-transition: all .2s ease;
   transition: all .2s ease;
   height: 77px;
   display: -webkit-box;
   display: -ms-flexbox;
   display: flex;
   -webkit-box-align: center;
   -ms-flex-align: center;
   align-items: center;
   -webkit-box-pack: center;
   -ms-flex-pack: center;
   justify-content: center;
   -webkit-box-orient: horizontal;
   -webkit-box-direction: normal;
   -ms-flex-direction: row;
   flex-direction: row;
   border-bottom: 1px solid transparent;
}
       .navbar span {
           position:relative;
           top:5px;
   background-image: url(https://goo.gl/NLUdLH);
   background-position: 0px 0px;
   height: 51px;
   width: 177px;
   display: inline-block;
   -webkit-transition: .3s cubic-bezier(0.18, 0.89, 0.32, 1.28);
   -o-transition: .3s cubic-bezier(0.18, 0.89, 0.32, 1.28);
   transition: .3s cubic-bezier(0.18, 0.89, 0.32, 1.28);
}
.navbar a i {
   position:relative;
   top:-10px;
   font-size: 45px;
   height: 43px;
   width: 43px;
   line-height: 42px;
   text-align: center;
   margin-right: 10px;
   border-radius: 6px;
   -webkit-transition: all .5s ease;
   -o-transition: all .5s ease;
   transition: all .5s ease;
}

.carousel-control-prev, .carousel-control-next{
   /*background: black;*/
   width: 4.5% !important;
   transition: opacity .2s ease-in;
}
.carousel-control-next-icon {
   background-image: url(https://image.flaticon.com/icons/svg/481/481146.svg) !important;
   transform: rotate(180deg);
}
.carousel-control-prev-icon {
   background-image: url(https://image.flaticon.com/icons/svg/481/481146.svg) !important;
}
.carousel-control-next-icon, .carousel-control-prev-icon {
   display: inline-block;
   width: 50px;
   height: 50px;
   background: transparent no-repeat center center;
   background-size: 100% 100%;
}
.carousel-control-next{right:-70px;}
.carousel-control-prev{left:-70px;}
.bisc {
   color: white;
   margin-right: 0px;
   background: -webkit-gradient(linear, right top, left bottom, from(#4c68d7), color-stop(#8a3ab9), color-stop(#cd486b), color-stop(#fb8750), to(#FF9800));
   background: -webkit-linear-gradient(right top, #4c68d7, #8a3ab9, #cd486b, #fb8750, #FF9800);
   background: -o-linear-gradient(right top, #4c68d7, #8a3ab9, #cd486b, #fb8750, #FF9800);
   background: linear-gradient(to left bottom, #4c68d7, #8a3ab9, #cd486b, #fb8750, #FF9800);
   -webkit-transform: rotate(360deg) scale(1.1);
   -ms-transform: rotate(360deg) scale(1.1);
   transform: rotate(360deg) scale(1.1);
}

       #demo {
           height: 100%;
           position: relative;
           overflow: hidden;
       }

       .green {
           background-color: #6fb936;
       }

       .page-top {
           margin-top: 150px;
       }

       .portfolio-item {
           margin-bottom: 30px;
       }

       .card {
           position: relative;
           display: -ms-flexbox;
           display: flex;
           -ms-flex-direction: column;
           flex-direction: column;
           min-width: 0;
           word-wrap: break-word;
           background-color: #fff;
           background-clip: border-box;
           border: none;
           border-radius: .25rem;
       }

       .myback-img {
           display: flex;
           justify-content: center;
           height: 372px;
           overflow: hidden;
           object-fit: cover;
           border-radius: .25rem;
       }

       .myoverlay {
           position: absolute;
           background: -webkit-linear-gradient( top, transparent 0%, rgba(0, 0, 0, 0.72) 100%);
           height: 100%;
           width: 100%;
           top: 0;
       }

       .card-body {
           -ms-flex: 1 1 auto;
           flex: 1 1 auto;
           padding: 0;
       }

       .avatar-profile img {
           width: 90px;
           height: 90px;
           border-radius: 100%;
           overflow: hidden;
           opacity: 0.9;
           object-fit: cover;
           -o-object-fit: cover;
       }

       .borders {
           position: relative;
           border: 5px solid #fff;
           border-radius: 100%;
       }

       .borders:before {
           content: " ";
           position: absolute;
           z-index: -1;
           top: -10px;
           left: -10px;
           right: -10px;
           bottom: -10px;
           border-radius: 100%;
           background-image: linear-gradient(90deg, #FDA240, #C5087E), linear-gradient(90deg, #FDA240, #C5087E);
           background-position: 0 0px, 100% 100%;
           background-size: 100% 5px;
           border-left: 5px solid #FDA240;
           border-right: 5px solid #C5087E;
           padding: 10px 5px;
       }

       .profile-img {
           position: absolute;
           top: 71%;
           left: 50%;
           transform: translate(-50%, -50%);
       }

       .profile-title {
           text-align: center;
           position: relative;
           top: -39px;
           margin-bottom: -26px;
       }

       .profile-title h3 {
           font-size: 18px;
           color: #fff;
           font-weight: bold;
           margin-bottom: 0;
       }

       a:hover {
           text-decoration: none !important;
       }
       /*--carousel css--*/

       @media (min-width: 768px) {
           /* show 3 items */
           .carousel-inner .active,
           .carousel-inner .active + .carousel-item,
           .carousel-inner .active + .carousel-item + .carousel-item,
           .carousel-inner .active + .carousel-item + .carousel-item + .carousel-item {
               display: block;
           }
           .carousel-inner .carousel-item.active:not(.carousel-item-right):not(.carousel-item-left),
           .carousel-inner .carousel-item.active:not(.carousel-item-right):not(.carousel-item-left) + .carousel-item,
           .carousel-inner .carousel-item.active:not(.carousel-item-right):not(.carousel-item-left) + .carousel-item + .carousel-item,
           .carousel-inner .carousel-item.active:not(.carousel-item-right):not(.carousel-item-left) + .carousel-item + .carousel-item + .carousel-item {
               transition: none;
           }
           .carousel-inner .carousel-item-next,
           .carousel-inner .carousel-item-prev {
               position: relative;
               transform: translate3d(0, 0, 0);
           }
           .carousel-inner .active.carousel-item + .carousel-item + .carousel-item + .carousel-item + .carousel-item {
               position: absolute;
               top: 0;
               right: -25%;
               z-index: -1;
               display: block;
               visibility: visible;
           }
           /* left or forward direction */
           .active.carousel-item-left + .carousel-item-next.carousel-item-left,
           .carousel-item-next.carousel-item-left + .carousel-item,
           .carousel-item-next.carousel-item-left + .carousel-item + .carousel-item,
           .carousel-item-next.carousel-item-left + .carousel-item + .carousel-item + .carousel-item,
           .carousel-item-next.carousel-item-left + .carousel-item + .carousel-item + .carousel-item + .carousel-item {
               position: relative;
               transform: translate3d(-100%, 0, 0);
               visibility: visible;
           }
           /* farthest right hidden item must be abso position for animations */
           .carousel-inner .carousel-item-prev.carousel-item-right {
               position: absolute;
               top: 0;
               left: 0;
               z-index: -1;
               display: block;
               visibility: visible;
           }
           /* right or prev direction */
           .active.carousel-item-right + .carousel-item-prev.carousel-item-right,
           .carousel-item-prev.carousel-item-right + .carousel-item,
           .carousel-item-prev.carousel-item-right + .carousel-item + .carousel-item,
           .carousel-item-prev.carousel-item-right + .carousel-item + .carousel-item + .carousel-item,
           .carousel-item-prev.carousel-item-right + .carousel-item + .carousel-item + .carousel-item + .carousel-item {
               position: relative;
               transform: translate3d(100%, 0, 0);
               visibility: visible;
               display: block;
               visibility: visible;
           }
       }
