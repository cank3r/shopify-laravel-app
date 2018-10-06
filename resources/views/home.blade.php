@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bolder-text text-white bg-primary">Verifying User</div>

                <div class="card-body text-center">
                    <form method="GET" action="{{ url('/get-products') }}">
                        <input type="hidden" name="access_token" id="access-token" value="">
                        <div class="loader col-md-12"></div>
                        <input type="submit" id="go-to-dashboard" class="btn btn-lg btn-info d-none" value="Go To Dashboard">
                    </form>
                    <div class="col-md-12 d-none" id="refresh-container">
                        <h4>Something went wrong while authenticating. Click on the button to refresh page.</h4>
                        <a href="{{ url('/home') }}" id="refresh-btn">
                            <button class="btn btn-lg btn-info"><i class="fas fa-sync-alt"></i> Refresh Page</button>
                        </a>
                    </div>
                </div>
                <iframe id="frame" src="" width="100%" height="300" hidden></iframe>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.alert').fadeOut(5000);
        $.ajax({
            url: "{{ url('/install-shop') }}",
        })
        .done(function(url) {
            $('#frame').attr('src',url);
            $('#frame').on('load', function(){ 
                var iframe = document.getElementById('frame');
                var access_token = iframe.contentWindow.document.getElementsByTagName('body')[0].innerHTML;
                if((typeof access_token) == 'string' || access_token[0].contentDocument) {
                    $('#access-token').val(access_token);
                    $('.card-header').empty().text('User Verified');
                    $('#go-to-dashboard').removeClass('d-none');
                    $('.loader').addClass('d-none');
                } else {
                    $('#refresh-container').removeClass('d-none');
                    $('.loader').addClass('d-none');
                }
            });
        });
    });
</script>
@endsection
