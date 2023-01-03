@extends('layouts.app')
<style>
    .center {
  display: block;
  margin-left: auto;
  margin-right: auto;
}
</style>
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    
                    {!! Form::open(['url'=>'login', 'class'=>'form-horizontal']) !!}

                    <div class="form-group">
                        <img src="images/splash.png" class="center">
                        <h4 style="text-align:center;">PT Nusa Indah Jaya Utama</h4>
                        <h5 style="text-align:center; color:gray;">Sign in untuk memulai!</h5>
                    </div>

                    <div class="form-group">
                        {!! Form::label('username', 'Username', ['class'=>'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('username', null, ['class'=>'form-control']) !!}
                            {!! $errors->first('username', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('password', 'Password', ['class'=>'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::password('password', ['class'=>'form-control']) !!}

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="button" id="sub-btn" class="btn btn-primary" style="float:right;">
                                <i></i> Login
                            </button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
$('#sub-btn').on('click', function() {
            validateButton();
        });
        function validateButton(){
            var username = $("#username").val();
            var password = $("#password").val();
            
            username = window.btoa(username);
            password = window.btoa(password);
            url = '{{ route('gismobile.validasi') }}'
            
            showLoading()
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'json',
                data : {
                    username : username,
                    password : password,
                },
                success: function(_respon) {
                        if (_respon.cekperiode == null) {
                            swal("Perhatian", "Perhatikan inputan anda, Username atau Password salah", "info").then(function() {
                            })
                            hideLoading()
                        }else {
                                inputData();
                        }
                },
                error: function(_respon) {
                    console.log(_respon)
                }
            })
        }
        function inputData(){
            var url = '{{ route("gismobile.index") }}'
            window.location = url;
        }
</script>
    @endsection