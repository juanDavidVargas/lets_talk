<!-- Footer -->
<footer class="text-center text-white footer">
    <!-- Grid container -->
    <div class="container">
        <!-- Section: Links -->
        <section class="mt-5">
            <!-- Grid row-->
            <div class="row text-center d-flex justify-content-center pt-5 padding">
                <!-- Grid column -->
                <div class="col-md-2 col-md-offset-2">
                    <h6 class="text-uppercase font-weight-bold">
                        <a href="#!" class="text-white">About us</a>
                    </h6>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-2">
                    <h6 class="text-uppercase font-weight-bold">
                        <a href="#!" class="text-white">Services</a>
                    </h6>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-2">
                    <h6 class="text-uppercase font-weight-bold">
                        <a href="#!" class="text-white">Help</a>
                    </h6>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-2">
                    <h6 class="text-uppercase font-weight-bold">
                        <a href="#!" class="text-white">Contact</a>
                    </h6>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row-->
        </section>
        <!-- Section: Links -->

        <hr class="my-5"/>

        <!-- Section: Text -->
        <section class="mb-4">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-8 col-lg-offset-2">
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt
                        distinctio earum repellat quaerat voluptatibus placeat nam,
                        commodi optio pariatur est quia magnam eum harum corrupti
                        dicta, aliquam sequi voluptate quas.
                    </p>
                </div>
            </div>
        </section>
        <!-- Section: Text -->

        <!-- Section: Social -->
        <section class="text-center mb-4">
            <a href="" class="text-white fa-2x facebook">
                <i class="fa fa-facebook-f"></i>
            </a>
            <a href="" class="text-white fa-2x twitter">
                <i class="fa fa-twitter"></i>
            </a>
            <a href="" class="text-white fa-2x google">
                <i class="fa fa-google"></i>
            </a>
            <a href="" class="text-white fa-2x insta">
                <i class="fa fa-instagram"></i>
            </a>
            <a href="" class="text-white fa-2x link">
                <i class="fa fa-linkedin"></i>
            </a>
        </section>
        <!-- Section: Social -->
    </div>
    <!-- Grid container -->

    <!-- Copyright -->
    <div class="text-center p-3 copy-footer">
        <p>
            All Rights Reserved ©
            <a class="text-white" href="#">Let's Talk</a> {{date('Y')}}
        </p>
    </div>
    <!-- Copyright -->
</footer>
<!-- Footer -->

@yield('scripts')
<!-- SCRIPTS -->
{{-- <script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script> --}}
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/functions.js') }}"></script>
<script src="{{ asset('js/homeslider.j') }}s"></script>
<script src="{{ asset('js/jquery.grid-a-licious.js') }}"></script>
<script src="{{ asset('js/404.js') }}"></script>

 {{-- Scripts Login Entrenador  --}}
<script src="{{asset('vendor/animsition/js/animsition.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap/js/popper.js')}}"></script>
<script src="{{asset('vendor/select2/select2.min.js')}}"></script>
<script src="{{asset('vendor/daterangepicker/moment.min.js')}}"></script>
<script src="{{asset('vendor/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('vendor/countdowntime/countdowntime.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>

{{-- Sweetalert --}}
<script src="{{asset('js/sweetalert2.all.js')}}"></script>
<script src="{{asset('js/sweetalert2.min.js')}}"></script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    </script>

@include('sweetalert::alert')
