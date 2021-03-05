@if($content)
    <style>
        .popup {
            display: flex;
            z-index: 999999;
            bottom: 0;
            top: 0;
            right: 0;
            left: 0;
            position: fixed;
            align-items: center;
            justify-content: center;
            background: rgba(0,0,0,0.5);
        }

        .popup .cw {
            position: relative;
            min-width: 576px;
            max-width: 576px;
            max-height: 80vh;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.15);
            max-width: 1168px;
            overflow-x: hidden;

            background-color: #fff;
        }

        .popup .cls {
            -webkit-appearance: button;
            -webkit-writing-mode: horizontal-tb !important;
            text-rendering: auto;
            color: buttontext;
            letter-spacing: normal;
            word-spacing: normal;
            text-transform: none;
            text-indent: 0px;
            text-shadow: none;
            display: inline-block;
            text-align: center;
            align-items: flex-start;
            cursor: default;
            background-color: buttonface;
            box-sizing: border-box;
            margin: 0em;
            font: 400 11px system-ui;
            padding: 1px 7px 2px;
            border-width: 1px;
            border-style: solid;
            border-color: rgb(216, 216, 216) rgb(209, 209, 209) rgb(186, 186, 186);
            border-image: initial;

            cursor: pointer;
            padding: 8px;
            top: 8px;
            right: 8px;
            position: absolute;
            flex: 0 0 auto;
            background-color: rgba(0,0,0,0);

        }

        .ic, .crs-w._gal .c-btn .ic {
            fill: #282828;
        }
        /*.modal-content {*/
        /*    background-color: transparent !important;*/
        /*}*/
    </style>
    <!--Newsletter modal popup start-->
    <div class="modal fade bd-example-modal-lg theme-modal" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="news-latter">
                        <div class="modal-bg">
                            <div class="offer-content">
                                <div>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <h2>newsletter</h2>
                                    <p>Subscribe to our website mailling list <br> and get a Offer, Just for you!</p>
                                    <form action="" class="auth-form needs-validation" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" target="_blank">
                                        <div class="form-group mx-sm-3">
                                            <div class="request-msg"></div>
                                            <input type="email" class="form-control" name="email-subscribe" id="mce-EMAIL" placeholder="Enter your email" required="required">
                                            <button type="submit" class="btn btn-theme btn-normal btn-sm subscribe-now" id="mc-submit">subscribe</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="news-latter d-none">
                        <div class="modal-bg">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                @php
                                    $product = \App\Product::find($content->product);
                                @endphp
                                @if(isset($product->url))
                                <a href="{{ $product->url }}"><img src="{{ image('module', $content->image) }}" width="100%" alt=""></a>
                                @endif
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Newsletter Modal popup end-->

    <div style="display: none" data-track-onview="popup" class="popup _open _l" data-auto-open="" data-pop-bg="" data-type="Newsletter">
        <section class="cw">
            <button data-track-onclick="popupClose" class="cls" aria-label="newsletter_popup_close-cta"
                    data-pop-close="">
                <svg viewBox="0 0 24 24" id="close"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path><path d="M0 0h24v24H0z" fill="none"></path></svg>
            </button>
            <div class="cont _nl">
                @php
                $product = \App\Product::find($content->product);
                @endphp
                @if(isset($product->url))
                <a href="{{ $product->url }}"><img src="{{ image('module', $content->image) }}" alt=""></a>
                @endif
            </div>
        </section>
    </div>
@endif
