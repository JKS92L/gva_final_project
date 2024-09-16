@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', 'grand-ebuy')
@section('content_header_title', 'grand-ebuy')
@section('content_header_subtitle', 'App')

{{-- Content body: main page content --}}
@section('content_body')
    <div class="col-12 col-xl-12">
        <div class="card card-primary card-outline card-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill"
                            href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home"
                            aria-selected="true">Buy items</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill"
                            href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile"
                            aria-selected="false">Sell item</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-messages-tab" data-toggle="pill"
                            href="#custom-tabs-three-messages" role="tab" aria-controls="custom-tabs-three-messages"
                            aria-selected="false">Payment Setting</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-settings-tab" data-toggle="pill"
                            href="#custom-tabs-three-settings" role="tab" aria-controls="custom-tabs-three-settings"
                            aria-selected="false"></a>
                    </li> --}}
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel"
                        aria-labelledby="custom-tabs-three-home-tab">

                        <div class="container mt-5 mb-5">
                            <div class="d-flex justify-content-center row">
                                <div class="col-md-10">
                                    <div class="row p-2 bg-white border rounded">
                                        <div class="col-md-3 mt-1"><img
                                                class="img-fluid img-responsive rounded product-image"
                                                src="https://i.imgur.com/QpjAiHq.jpg"></div>
                                        <div class="col-md-6 mt-1">
                                            <h5>Quant olap shirts</h5>
                                            <div class="d-flex flex-row">
                                                <div class="ratings mr-2"><i class="fa fa-star"></i><i
                                                        class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                        class="fa fa-star"></i></div><span>310</span>
                                            </div>
                                            <div class="mt-1 mb-1 spec-1"><span>100% cotton</span><span
                                                    class="dot"></span><span>Light weight</span><span
                                                    class="dot"></span><span>Best finish<br></span></div>
                                            <div class="mt-1 mb-1 spec-1"><span>Unique design</span><span
                                                    class="dot"></span><span>For men</span><span
                                                    class="dot"></span><span>Casual<br></span></div>
                                            <p class="text-justify text-truncate para mb-0">There are many variations of
                                                passages of Lorem Ipsum available, but the majority have suffered alteration
                                                in some form, by injected humour, or randomised words which don't look even
                                                slightly believable.<br><br></p>
                                        </div>
                                        <div class="align-items-center align-content-center col-md-3 border-left mt-1">
                                            <div class="d-flex flex-row align-items-center">
                                                <h4 class="mr-1">K 13.99</h4><span class="strike-text">K 20.99</span>
                                            </div>
                                            <h6 class="text-success">Free shipping</h6>
                                            <div class="d-flex flex-column mt-4"><button class="btn btn-primary btn-sm"
                                                    type="button">Details</button><button
                                                    class="btn btn-outline-primary btn-sm mt-2" type="button">Add to
                                                    wishlist</button></div>
                                        </div>
                                    </div>
                                    <div class="row p-2 bg-white border rounded mt-2">
                                        <div class="col-md-3 mt-1"><img
                                                class="img-fluid img-responsive rounded product-image"
                                                src="https://i.imgur.com/JvPeqEF.jpg"></div>
                                        <div class="col-md-6 mt-1">
                                            <h5>Quant trident shirts</h5>
                                            <div class="d-flex flex-row">
                                                <div class="ratings mr-2"><i class="fa fa-star"></i><i
                                                        class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                        class="fa fa-star"></i></div><span>310</span>
                                            </div>
                                            <div class="mt-1 mb-1 spec-1"><span>100% cotton</span><span
                                                    class="dot"></span><span>Light weight</span><span
                                                    class="dot"></span><span>Best finish<br></span></div>
                                            <div class="mt-1 mb-1 spec-1"><span>Unique design</span><span
                                                    class="dot"></span><span>For men</span><span
                                                    class="dot"></span><span>Casual<br></span></div>
                                            <p class="text-justify text-truncate para mb-0">There are many variations of
                                                passages of Lorem Ipsum available, but the majority have suffered alteration
                                                in some form, by injected humour, or randomised words which don't look even
                                                slightly believable.<br><br></p>
                                        </div>
                                        <div class="align-items-center align-content-center col-md-3 border-left mt-1">
                                            <div class="d-flex flex-row align-items-center">
                                                <h4 class="mr-1">K 14.99</h4><span class="strike-text">K 20.99</span>
                                            </div>
                                            <h6 class="text-success">Free shipping</h6>
                                            <div class="d-flex flex-column mt-4"><button class="btn btn-primary btn-sm"
                                                    type="button">Details</button><button
                                                    class="btn btn-outline-primary btn-sm mt-2" type="button">Add to
                                                    wishlist</button></div>
                                        </div>
                                    </div>
                                    <div class="row p-2 bg-white border rounded mt-2">
                                        <div class="col-md-3 mt-1"><img
                                                class="img-fluid img-responsive rounded product-image"
                                                src="https://i.imgur.com/Bf4dIaN.jpg"></div>
                                        <div class="col-md-6 mt-1">
                                            <h5>Quant ruybi shirts</h5>
                                            <div class="d-flex flex-row">
                                                <div class="ratings mr-2"><i class="fa fa-star"></i><i
                                                        class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                        class="fa fa-star"></i></div><span>123</span>
                                            </div>
                                            <div class="mt-1 mb-1 spec-1"><span>100% cotton</span><span
                                                    class="dot"></span><span>Light weight</span><span
                                                    class="dot"></span><span>Best finish<br></span></div>
                                            <div class="mt-1 mb-1 spec-1"><span>Unique design</span><span
                                                    class="dot"></span><span>For men</span><span
                                                    class="dot"></span><span>Casual<br></span></div>
                                            <p class="text-justify text-truncate para mb-0">There are many variations of
                                                passages of Lorem Ipsum available, but the majority have suffered alteration
                                                in some form, by injected humour, or randomised words which don't look even
                                                slightly believable.<br><br></p>
                                        </div>
                                        <div class="align-items-center align-content-center col-md-3 border-left mt-1">
                                            <div class="d-flex flex-row align-items-center">
                                                <h4 class="mr-1">K 13.99</h4><span class="strike-text">K 20.99</span>
                                            </div>
                                            <h6 class="text-success">Free shipping</h6>
                                            <div class="d-flex flex-column mt-4"><button class="btn btn-primary btn-sm"
                                                    type="button">Details</button><button
                                                    class="btn btn-outline-primary btn-sm mt-2" type="button">Add to
                                                    wishlist</button></div>
                                        </div>
                                    </div>
                                    <div class="row p-2 bg-white border rounded mt-2">
                                        <div class="col-md-3 mt-1"><img
                                                class="img-fluid img-responsive rounded product-image"
                                                src="https://i.imgur.com/HO8e9b8.jpg"></div>
                                        <div class="col-md-6 mt-1">
                                            <h5>Quant tinor shirts</h5>
                                            <div class="d-flex flex-row">
                                                <div class="ratings mr-2"><i class="fa fa-star"></i><i
                                                        class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                        class="fa fa-star"></i></div><span>110</span>
                                            </div>
                                            <div class="mt-1 mb-1 spec-1"><span>100% cotton</span><span
                                                    class="dot"></span><span>Light weight</span><span
                                                    class="dot"></span><span>Best finish<br></span></div>
                                            <div class="mt-1 mb-1 spec-1"><span>Unique design</span><span
                                                    class="dot"></span><span>For men</span><span
                                                    class="dot"></span><span>Casual<br></span></div>
                                            <p class="text-justify text-truncate para mb-0">There are many variations of
                                                passages of Lorem Ipsum available, but the majority have suffered alteration
                                                in some form, by injected humour, or randomised words which don't look even
                                                slightly believable.<br><br></p>
                                        </div>
                                        <div class="align-items-center align-content-center col-md-3 border-left mt-1">
                                            <div class="d-flex flex-row align-items-center">
                                                <h4 class="mr-1">K 15.99</h4><span class="strike-text">K 21.99</span>
                                            </div>
                                            <h6 class="text-success">Free shipping</h6>
                                            <div class="d-flex flex-column mt-4"><button class="btn btn-primary btn-sm"
                                                    type="button">Details</button><button
                                                    class="btn btn-outline-primary btn-sm mt-2" type="button">Add to
                                                    wishlist</button></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel"
                        aria-labelledby="custom-tabs-three-profile-tab">
                        Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula
                        tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas
                        sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus.
                        Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque
                        diam.
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-three-messages" role="tabpanel"
                        aria-labelledby="custom-tabs-three-messages-tab">
                        Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue id
                        mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac
                        tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit
                        condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus tristique.
                        Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet sollicitudin est
                        libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum
                        metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend ac ornare magna.
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-three-settings" role="tabpanel"
                        aria-labelledby="custom-tabs-three-settings-tab">
                        Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus turpis ac,
                        ornare sodales tellus. Mauris eget blandit dolor. Quisque tincidunt venenatis vulputate. Morbi
                        euismod molestie tristique. Vestibulum consectetur dolor a vestibulum pharetra. Donec interdum
                        placerat urna nec pharetra. Etiam eget dapibus orci, eget aliquet urna. Nunc at consequat diam. Nunc
                        et felis ut nisl commodo dignissim. In hac habitasse platea dictumst. Praesent imperdiet accumsan ex
                        sit amet facilisis.
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@stop

{{-- Push extra CSS --}}
@push('css')
    {{-- Add extra stylesheets --}}
    <style>
        .card-body {
            height: 500px;
            overflow-y: auto;
            padding: 20px;
            background-color: #ffffff;
        }

        body {
            background: #eee
        }

        .ratings i {
            font-size: 16px;
            color: red
        }

        .strike-text {
            color: red;
            text-decoration: line-through
        }

        .product-image {
            width: 100%
        }

        .dot {
            height: 7px;
            width: 7px;
            margin-left: 6px;
            margin-right: 6px;
            margin-top: 3px;
            background-color: blue;
            border-radius: 50%;
            display: inline-block
        }

        .spec-1 {
            color: #938787;
            font-size: 15px
        }

        h5 {
            font-weight: 400
        }

        .para {
            font-size: 16px
        }

        /* Font Import */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
    </style>
@endpush

{{-- Push extra scripts --}}
@push('js')
    <script>
        // Optional JS scripts here
    </script>
@endpush
