@extends('layouts.theme')
@section('title','Purchase Plan')
@section('main-wrapper')
  <!-- main wrapper -->
  <section id="main-wrapper" class="main-wrapper home-page user-account-section">
    <div class="container-fluid">
      <h4 class="heading">Complete your payment</h4>
      <ul class="bradcump">
        <li><a href="{{url('account')}}">Dashboard</a></li>
        <li>/</li>
        <li>Pricing Plan</li>
        <li>/</li>
        <li>{{$plan->name}}</li>
      </ul>
      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
          <!-- -->
          <div class="card" style="border: 1px solid #000; border-radius: 5px; background-color:#fff;">
            <div class="text-center push">
                <div class="text-center"><small class="text-muted" id="timeleft"></small></div>
                <script>var countDownDate = {{$etinfo['time_expires']}}000;</script>
                <div style="background-color:#333; color:#fff;">
                    <div>You have to send</div>
                    <span class="h3">{{$tinfo["amount2"]}}</span>
                    <div >{{$tinfo["currency2"]}}</div>
                </div><br/>
                <small class="font-size-sm text-muted" >{{$etinfo["recv_confirms"]}} / {{$tinfo["confirms_needed"]}} Confirmations</small>
            </div>
            <div class="" style="padding: 5px;">
              <div class="form-group">
                  <label for="pmaddress">{{$tinfo["currency2"]}} Address:</label>
                  <input type="text" class="form-control form-control-alt text-center" id="pmaddress" name="pmaddress" value="{{$etinfo['payment_address']}}" placeholder="BITCOIN ADDRESS" disabled>
                  <small class="form-text text-muted text-center"><a href="#" onclick="CopyOnClipboardBtcAddress()"><i class="fa fa-copy"></i> Copy on clipboard</a></small>
              </div>
              <div class="form-group row m-t-20">
                  <div class="col-sm-6 text-left"><button class="btn btn-primary" type="button" data-toggle="modal" data-target="#QrCodeBtc"><i class="fa fa-qrcode"></i> QR Code</button></div>
                  <div class="col-sm-6 text-right"><a class="btn btn-primary" href="{{$tinfo['status_url']}}" target="_blank"><i class="fa fa-tasks"></i> Payment status</a></div>
              </div>
            </div>
          </div>
          <!---->
        </div>
        <div class="col-md-4"></div>
      </div>
    </div>
  </section>
  <div class="modal" id="QrCodeBtc">
      <div class="modal-dialog" style="width: 246px; z-index: 99999;">
          <div class="modal-content">
              <img src="{{$tinfo['qrcode_url']}}" alt="QRCODE">
              <button type="button" class="btn btn-block btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
          </div>
      </div>
  </div>

  <!-- end main wrapper -->
  <script>
    function CopyOnClipboardBtcAddress() {
      var addr = document.getElementById("pmaddress");
      addr.disabled = false;
      addr.select();
      document.execCommand("copy");
      alert("Adress Copied: " + addr.value);
      addr.disabled = true;
    }
    var x = setInterval(function() {

      var now = new Date().getTime();
        
      var distance = countDownDate - now;
        
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
      document.getElementById("timeleft").innerHTML = "Time left: " + days + "d " + hours + "h "
      + minutes + "m " + seconds + "s ";
        
      if (distance < 0) {
        clearInterval(x);
        window.location.reload(true);
        location.reload();
      }
    }, 1000);
  </script>
@endsection
