<style>
    .mcd-menu {
        list-style: none;
        padding: 0;
        margin: 0;
        background: #fff;
        /*height: 100px;*/
        -moz-border-radius: 2px;
        -webkit-border-radius: 2px;
        border: 1px solid rgba(204, 200, 200, 0.22);
        height: 550px;
        box-shadow: 3px 3px 3px -4px  #585555;
        border: 1px solid #979191;
        /* overflow:auto ; */
        margin-right :15px ;
        box-shadow: 1px 1px 7px -1px grey;
        -webkit-box-shadow: 1px 1px 7px -1px grey;
        -o-box-shadow: 1px 1px 7px -1px grey;
        -moz-box-shadow: 1px 1px 7px -1px grey;

    }
    .mcd-menu li {
        position: relative;
        display: block;
        /*float:left;*/
    }
    .mcd-menu li a {
        display: block;
        font-size: 14px ;
        text-decoration: none;
        padding: 20px 20px;
        color: #000;
        @if(\Illuminate\Support\Facades\App::getLocale() == "ar")
        text-align: right;
        @else
        text-align: left;
        @endif
        height: 36px;
        position: relative;
        border-bottom: 1px solid #EEE;
        /* == */
    }
    .mcd-menu li a i {
        @if(\Illuminate\Support\Facades\App::getLocale() == "ar")
        float: right;
        @else
        float: left;
        @endif
        font-size: 20px;
        @if(\Illuminate\Support\Facades\App::getLocale() == "ar")
                margin: -10px 0px 0 10px;
        @else
                margin: -10px 10px 0 0;
        @endif
    }
    /* == */
    .mcd-menu li a p {
        @if(\Illuminate\Support\Facades\App::getLocale() == "ar")
        float: left;
        @else
        float: left;
        @endif
        margin: 0 ;
    }
    /* == */

    .mcd-menu li a strong {
        display: block;
        text-transform: uppercase;
    }


    /*.mcd-menu li:hover > a {*/
    /*    color: #b33128;*/
    /*}*/
    /*.mcd-menu li a.active ,*/
    .mcd-menu li:hover > a
    {
        position: relative;
        color: #b33128;
        /* border:0; */
        box-shadow: 0 0 5px #DDD;
        -moz-box-shadow: 0 0 5px #DDD;
        -webkit-box-shadow: 0 0 5px #DDD;
        /* border-left: 4px solid #b33128;
        border-right: 4px solid #b33128;
        margin: 0 -4px; */
    }
    /*.mcd-menu li a.active:before ,*/
    .mcd-menu li:hover > a:before
    {
        content: "";
        position: absolute;
        /* == */
        top: 42%;
        left: 0;
        /* border-left: 5px solid #b33128;
        border-top: 5px solid transparent;
        border-bottom: 5px solid transparent; */
        /* == */
    }

    /* == */
/*
    .mcd-menu li a.active:after ,
*/
    .mcd-menu li:hover > a:after
    {
        content: "";
        position: absolute;
        top: 42%;
        right: 0;
        /* border-right: 5px solid #b33128;
        border-top: 5px solid transparent;
        border-bottom: 5px solid transparent; */
    }
    /* == */



    .mcd-menu li ul,
    .mcd-menu li ul li ul {
        position: absolute;
        height: auto;
        min-width: 200px;
        padding: 0;
        margin: 0;
        background: #FFF;
        /*border-top: 4px solid #b33128;*/
        opacity: 0;
        display: none;
        transition: all 5s ease-in-out;
        -o-transition: all 5s ease-in-out;
        -ms-transition: all 5s ease-in-out;
        -moz-transition: all 5s ease-in-out;
        -webkit-transition: all 5s ease-in-out;
        /*top: 130px;*/
        z-index:333333;
        

        /* == */
        @if(\Illuminate\Support\Facades\App::getLocale() == "ar")
                right:200px;
        @else
                left:200px;
        @endif
        top: 0px;
        border-left: 4px solid #b33128;
        border-right: 1px solid #000;
        /* == */
    }
    .mcd-menu li ul:before {
        content: "";
        position: absolute;
        top: 25px;
        /*left: -9px;*/
        border-right: 5px solid #b33128;
        border-bottom: 5px solid transparent;
        border-top: 5px solid transparent;
        /* == */
    }
    .mcd-menu li:hover > ul,
    .mcd-menu li ul li:hover > ul {
        display: block;
        opacity: 1;
        display: block;
        left:185pxpx; 
    }
    /*.mcd-menu li ul li {
      float: none;
    }*/
    .mcd-menu li ul li a {
        padding: 0; /*change this form 20px */
        @if(\Illuminate\Support\Facades\App::getLocale() == "ar")
        text-align: right;
        @else
        text-align: left;
        @endif

        border: 0;
        border-bottom: 1px solid #EEE;

        /* == */
        height: auto;
        /* == */
    }
    .mcd-menu li ul li a i {
        font-size: 16px;
        display: inline-block;
        @if(\Illuminate\Support\Facades\App::getLocale() == "ar")
        margin: 0 0 0 10px;
        @else
        margin: 0 10px 0 0;
        @endif

    }
    .mcd-menu li ul li ul {
        @if(\Illuminate\Support\Facades\App::getLocale() == "ar")
                right:185px;
        @else
                left:185px;
        @endif

        top: 0;
        border: 0;
        border-left: 4px solid #b33128;
    }
    .mcd-menu li ul li ul:before {
        content: "";
        position: absolute;
        top: 15px;
        /*left: -14px;*/
        /* == */
        /*left: -9px;*/
        /* == */
        border-right: 5px solid #b33128;
        border-bottom: 5px solid transparent;
        border-top: 5px solid transparent;
    }
    .mcd-menu li ul li:hover > ul {
        top: 0px;
        left: 200px;
    }



    /*.mcd-menu li.float {
      float: right;
    }*/
    .mcd-menu li a.search {
        /*padding: 29px 20px 30px 10px;*/
        padding: 10px 10px 15px 10px;
        clear: both;
    }
    .mcd-menu li a.search i {
        margin: 0;
        display: inline-block;
        font-size: 18px;
    }
    .mcd-menu li a.search input {
        border: 1px solid #EEE;
        padding: 10px;
        background: #FFF;
        outline: none;
        color: #777;

        /* == */
        width:170px;
        float:left;
        /* == */
    }
    .mcd-menu li a.search button {
        border: 1px solid #b33128;
        /*padding: 10px;*/
        background: #b33128;
        outline: none;
        color: #FFF;
        margin-left: -4px;

        /* == */
        float:left;
        padding: 10px 10px 11px 10px;
        /* == */
    }
    .mcd-menu li a.search input:focus {
        border: 1px solid #b33128;
    }


    .search-mobile {
        display:none !important;
        background:#b33128;
        border-left:1px solid #b33128;
        border-radius:0 3px 3px 0;
    }
    .search-mobile i {
        color:#FFF;
        margin:0 !important;
    }


    @media only screen and (min-width: 960px) and (max-width: 1199px) {
        .mcd-menu {
            margin-left:10px;
        }
    }

    @media only screen and (min-width: 768px) and (max-width: 959px) {
        .mcd-menu {
            width: 200px;
        }
        .mcd-menu li a {
            height:30px;
        }
        .mcd-menu li a i {
            font-size: 22px;
        }
        .mcd-menu li a strong {
            font-size: 12px;
        }
        .mcd-menu li a small {
            font-size: 10px;
        }
        .mcd-menu li a.search input {
            width: 120px;
            font-size: 12px;
        }
        .mcd-menu li a.search buton{
            padding: 8px 10px 9px 10px;
        }
        .mcd-menu li > ul {
            min-width:180px;
        }
        .mcd-menu li:hover > ul {
            min-width:180px;
            left:200px;
        }
        .mcd-menu li ul li > ul, .mcd-menu li ul li ul li > ul {
            min-width:150px;
        }
        .mcd-menu li ul li:hover > ul {
            left:180px;
            min-width:150px;
        }
        .mcd-menu li ul li ul li:hover > ul {
            left:150px;
            min-width:150px;
        }
        .mcd-menu li ul a {
            font-size:12px;
        }
        .mcd-menu li ul a i {
            font-size:14px;
        }
    }

    @media only screen and (min-width: 480px) and (max-width: 767px) {

        .mcd-menu {
            width: 50px;
        }
        .mcd-menu li a {
            position: relative;
            padding: 12px 16px;
            height:20px;
        }
        .mcd-menu li a small {
            display: none;
        }
        .mcd-menu li a strong {
            display: none;
        }
        .mcd-menu li a:hover strong,.mcd-menu li a.active strong {
            display:block;
            font-size:10px;
            padding:3px 0;
            position:absolute;
            bottom:0px;
            left:0;
            background:#b33128;
            color:#FFF;
            min-width:100%;
            text-transform:lowercase;
            font-weight:normal;
            text-align:center;
        }
        .mcd-menu li .search {
            display: none;
        }

        .mcd-menu li > ul {
            min-width:180px;
            left:70px;
        }
        .mcd-menu li:hover > ul {
            min-width:180px;
            left:50px;
        }
        .mcd-menu li ul li > ul, .mcd-menu li ul li ul li > ul {
            min-width:150px;
        }
        .mcd-menu li ul li:hover > ul {
            left:180px;
            min-width:150px;
        }
        .mcd-menu li ul li ul li > ul {
            left:35px;
            top: 45px;
            border:0;
            border-top:4px solid #b33128;
        }
        .mcd-menu li ul li ul li > ul:before {
            left:30px;
            top: -9px;
            border:0;
            border-bottom:5px solid #b33128;
            border-left:5px solid transparent;
            border-right:5px solid transparent;
        }
        .mcd-menu li ul li ul li:hover > ul {
            left:30px;
            min-width:150px;
            top: 35px;
        }
        .mcd-menu li ul a {
            font-size:12px;
        }
        .mcd-menu li ul a i {
            font-size:14px;
        }

    }

    @media only screen and (max-width: 479px) {
        .mcd-menu {
            width: 50px;
        }
        .mcd-menu li a {
            position: relative;
            padding: 12px 16px;
            height:20px;
        }
        .mcd-menu li a small {
            display: none;
        }
        .mcd-menu li a strong {
            display: none;
        }
        .mcd-menu li a:hover strong,.mcd-menu li a.active strong {
            display:block;
            font-size:10px;
            padding:3px 0;
            position:absolute;
            bottom:0px;
            left:0;
            background:#b33128;
            color:#FFF;
            min-width:100%;
            text-transform:lowercase;
            font-weight:normal;
            text-align:center;
        }
        .mcd-menu li .search {
            display: none;
        }

        .mcd-menu li > ul {
            min-width:180px;
            left:70px;
        }
        .mcd-menu li:hover > ul {
            min-width:180px;
            left:50px;
        }
        .mcd-menu li ul li > ul, .mcd-menu li ul li ul li > ul {
            min-width:150px;
        }
        .mcd-menu li ul li:hover > ul {
            left:180px;
            min-width:150px;
        }
        .mcd-menu li ul li ul li > ul {
            left:35px;
            top: 45px;
            border:0;
            border-top:4px solid #b33128;
        }
        .mcd-menu li ul li ul li > ul:before {
            left:30px;
            top: -9px;
            border:0;
            border-bottom:5px solid #b33128;
            border-left:5px solid transparent;
            border-right:5px solid transparent;
        }
        .mcd-menu li ul li ul li:hover > ul {
            left:30px;
            min-width:150px;
            top: 35px;
        }
        .mcd-menu li ul a {
            font-size:12px;
        }
        .mcd-menu li ul a i {
            font-size:14px;
        }

    }

</style>


{{-- {{ dd($categories) }} --}}
<nav class="d-none d-xl-block">
        <ul class="mcd-menu">
            @foreach($categories as $header)
                @if(count($header->children) > 0)
                    @foreach($header->children as $child)
                        @if(count($child->children) > 0)
                            @php $level= 3 @endphp
                            @break
                        @else
                            @php $level= 2 @endphp
                        @endif
                    @endforeach
                @else
                    @php $level= 1 @endphp
                @endif
                @if($level == 1)
                        <li>
                            <a href="{{url('/'.$locale.'/'.$header->slug.'/c')}}">
                                <i class="fa fa-gift"></i>
                                <strong>{{$header->name}}</strong>
                            </a>
                        </li>

               @elseif($level == 2)
                        <li>
                            <a href="{{url('/'.$locale.'/'.$header->slug.'/c')}}">
                                <i class="fa fa-gift"></i>
                                <strong>{{$header->name}}</strong>
                            </a>
                            <ul>
                                @foreach($header->children as $child)
                                    <li><a href="{{url('/'.$locale.'/'.$child->slug.'/c')}}"><i class="fa fa-globe"></i>{{$child->name}}</a></li>
                                @endforeach

                            </ul>

                        </li>

                        @elseif($level == 3)
                        <li>
                            <a href="{{url('/'.$locale.'/'.$header->slug.'/c')}}">
                                <i class="fa fa-home"></i>
                                <strong>{{$header->name}}</strong>

                            </a>
                            <ul>
                                @foreach($header->children as $child)
                                    <li>
                                        <a href="{{url('/'.$locale.'/'.$child->slug.'/c')}}"><i class="fa fa-globe"></i>{{$child->name}}</a>
                                        <ul>
                                            @foreach($child->children as $ch)
                                                <li><a href="{{url('/'.$locale.'/'.$ch->slug.'/c')}}">{{$ch->name}}</a></li>
                                            @endforeach
                                        </ul>

                                    </li>
                                @endforeach

                            </ul>
                        </li>
                @endif
                @endforeach
        </ul>
    </nav>
