@extends('layouts.app')

@section('content')
<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
<script type="text/javascript">
    $(window).on('load', function() {
        //$('#dashboard_menu').addClass('active');
        getBalance();
    });
    function copyToClipboard() {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($('#erc20_wallet').html()).select();
        document.execCommand("copy");
        $temp.remove();
    }
    function getBalance() {
        var token = $("input[name=_token]").val();
        $('.amounts').html('Loading...');
        $.ajax({
            url: '{{ route('dashboard.getbalance') }}',
            type: 'POST',
            data: {_token: token},
            dataType: 'JSON',
            success: function (response) {
                $('#total_amount').html(response.purchased);
                $('#mng_amount').html(response.managing);
                $('#unlocked_amount').html(response.unlocked);
                $('#available_amount').html(response.available);
                $('#withdrawal_amount').html(response.withdrawn);
            }
        });
    }
</script>

<section id="content" class="parallax-section">
    <section id="content" class="parallax-section">
        <form method="post" id="signin-form">
            <input type="hidden" name="_token" value="Hi3efaL6hCUOcxVQBxt73Dv38zABoXZ8Yx0WdapB">
            <div class="container">
                <div class="row">
                    <div id="contect-box">
                        <h3>{{trans('dashboard.balance')}}</h3>
                        <hr align="left">
                        <h5 style="color: #4780A0;"><i class="fas fa-coins"></i>&nbsp;&nbsp;{{trans('common.balance.total_amount')}}</p></h5>
                        <h4 class="control-label alert-content amounts" style="padding-left: 20px;" id="total_amount"></h4>
                        <h5 style="color: #4780A0;"><i class="fas fa-coins"></i>&nbsp;&nbsp;{{trans('common.balance.dashboard_mng_amount')}}</p></h5>
                        <h4 class="control-label alert-content amounts" style="padding-left: 20px;" id="mng_amount"></h4>
                        <h5 style="color: #4780A0;"><i class="fas fa-unlock"></i>&nbsp;&nbsp;{{trans('common.balance.unlocked_amount')}}</p></h5>
                        <h4 class="control-label alert-content amounts" style="padding-left: 20px;" id="unlocked_amount"></h4>
                        <h5 style="color: #4780A0;"><i class="fas fa-wallet"></i>&nbsp;&nbsp;{{trans('common.balance.available_amount')}}</p></h5>
                        <h4 class="control-label alert-content amounts" style="padding-left: 20px;" id="available_amount"></h4>
                        <h5 style="color: #4780A0;"><i class="fas fa-outdent"></i>&nbsp;&nbsp;{{trans('common.balance.withdrawal_amount')}}</p></h5>
                        <h4 class="control-label alert-content amounts" style="padding-left: 20px;" id="withdrawal_amount"></h4>
                    </div>
                </div>
            </div>
        </form>
    </section>
</section>
@endsection
