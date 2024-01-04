@extends('layouts.app')

@section('content')

<!-- main-content-wrap start -->
<div class="main-content-wrap section-ptb lagin-and-register-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 m-auto">
                <div class="login-register-wrapper">
                    <!-- login-register-tab-list start -->
                    <!-- login-register-tab-list end -->
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                                @endif
                                @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                                @endif
                                <h4> Tra cứu đơn hàng của bạn</h4>
                                <p class="secon-title-login">Bạn vui lòng nhập email hoặc số điện thoại và mã đơn hàng để tra cứu</p>
                                <div class="login-register-form">
                                    <form action="{{ route('order.search') }}" method="post">
                                        @csrf
                                        <div class="login-input-box">
                                            <div class="col_full">
                                                <label for="email_or_phone">Email hoặc Số điện thoại<span class="required">*</span></label>
                                                <input type="text" name="email_or_phone" class="form-control">

                                            </div>
                                            <div class="col_full">
                                                <label for="order_code">Mã đơn hàng (Ví dụ: OD92823736)<span class="required">*</span></label>
                                                <input type="text" name="order_code" class="form-control">

                                            </div>
                                        </div>
                                        <div class="button-box">
                                            <div class="button-box">
                                                <button class="button login-btn" type="submit" value="login"><span>Tra cứu đơn hàng</span></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- main-content-wrap end -->
@endsection
