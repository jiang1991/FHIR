<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>深圳源动创新科技有限公司</title>

  <!-- Fonts -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

  <!-- Styles -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

  <style type="text/css">
    body {
      font-family: 'Lato';
    }

    .fa-btn {
      margin-right: 6px;
    }
  </style>

  <!-- JavaScripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

  {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</head>

<body id="app-layout">

  <div class="container">
    <div class="row"> 
      <h1> </h1>
    </div>
  </div>

  <nav class="navbar navbar-default navbar-static-top">
    <div class="container">
      <div class="navbar-header">

        <!-- Collapsed Hamburger -->
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
          <span class="sr-only">Toggle Navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>

      </div>

      <div class="collapse navbar-collapse" id="app-navbar-collapse">

        <ul class="nav navbar-nav">
          <li>
            <div>
              <div class="row">
                <a href="{{ url('/') }}">
                  <img src="pics/imgs/logo.webp" class=".img-responsive" width="120px" alt="深圳源动创新科技有限公司" />
                </a>
              </div>
              <div class="row">
                深圳源动创新科技有限公司
              </div>
            </div>
          </li>
        </ul>

        <!-- Left Side Of Navbar -->
        <ul class="nav navbar-nav navbar-right">
          <li><a href="{{ url('https://www.viatomtech.com/checkme-o2') }}">Checkme O2</a></li>
          <li><a href="{{ url('https://www.viatomtech.com/snoreo2') }}">SnoreO2</a></li>
          <li><a href="{{ url('https://www.viatomtech.com/sleepo2') }}">SleepO2</a></li>
          <li><a href="{{ url('https://www.viatomtech.com/checkme-pro') }}">Checkme Pro</a></li>
          <li><a href="{{ url('https://www.viatomtech.com/checkme-lite') }}">Checkme Lite</a></li>
          <li><a href="{{ url('https://www.viatomtech.com/heartmate') }}">HeartMate</a></li>
          <li><a href="{{ url('https://www.viatomtech.com/airbp') }}">AirBP</a></li>
        </ul>
      </div>
    </div>
  </nav>


  <!-- O2 -->
  <div class="container">
    <h1>Sleep Monitor with Vibration<br><small>Understand and improve your sleep more easily</small> </h1>

    <div class="row">
      <tr>
        <td>
          <table>
            <div class="col-md-4">
              <div class="row">
                <a href="{{ url('https://www.viatomtech.com/checkme-o2') }}">
                  <img src="pics/imgs/ceo2.png" class=".img-responsive .center-block" alt="Checkme O2" width="350px"/>
                </a>
              </div>
              <div class="row text-center">
                <h2>Checkme O2</h2>
              </div>
            </div>
          </table>
        </td>

        <td>
          <table>
            <div class="col-md-4">
              <div class="row">
                <a href="{{ url('https://www.viatomtech.com/snoreo2') }}">
                  <img src="pics/imgs/snoreo2.png" class=".img-responsive .center-block" alt="SnoreO2" width="350px"/>
                </a>
              </div>
              <div class="row text-center">
                <h2>SnoreO2</h2>
              </div>
            </div>
          </table>
        </td>

        <td>
          <table>
            <div class="col-md-4">
              <div class="row">
                <a href="{{ url('https://www.viatomtech.com/sleepo2') }}">
                  <img src="pics/imgs/sleepo2.png" class=".img-responsive .center-block" alt="Sleep" width="350px" />
                </a>
              </div>
              <div class="row text-center">
                <h2>SleepO2</h2>
              </div>
            </div>
          </table>
        </td>
      </tr>

    </div>
  </div>

  <div class="container">
    <br>
  </div>

  <!-- pro -->
  <div class="container">
    <h1>Vital Signs Monitor<br><small>Track your ECG & SpO2 anywhere & anytime</small> </h1>

    <div class="row">
      <tr>
        <td>
          <table>
            <div class="col-md-4">
              <div class="row">
                <a href="{{ url('https://www.viatomtech.com/checkme-pro') }}">
                  <img src="pics/imgs/checkme_pro.png" class=".img-responsive .center-block" alt="Checkme Pro" width="350px"/>
                </a>
              </div>
              <div class="row text-center">
                <h2>Checkme Pro</h2>
              </div>
            </div>
          </table>
        </td>

        <td>
          <table>
            <div class="col-md-4">
              <div class="row">
                <a href="{{ url('https://www.viatomtech.com/checkme-lite') }}">
                  <img src="pics/imgs/checkme_lite.png" class=".img-responsive .center-block" alt="Checkme Lite" width="350px"/>
                </a>
              </div>
              <div class="row text-center">
                <h2>Checkme Lite</h2>
              </div>
            </div>
          </table>
        </td>

        <td>
          <table>
            <div class="col-md-4">
              <div class="row">
                <a href="{{ url('https://www.viatomtech.com/heartmate') }}">
                  <img src="pics/imgs/heartmate.png" class=".img-responsive .center-block" alt="HeartMate" width="350px"/>
                </a>
              </div>
              <div class="row text-center">
                <h2>HeartMate</h2>
              </div>
            </div>
          </table>
        </td>
      </tr>

    </div>
  </div>

  <div class="container">
    <br>
  </div>

  <!-- airbp -->
  <div class="container">
    <h1>Ultra-Portable Smart UPPER ARM<br> Blood Pressure Monitor</h1>

    <div class="row">
      <tr>
        <td>
          <table>
            <div class="col-md-4">
              <div class="row">
                <a href="{{ url('https://www.viatomtech.com/airbp') }}">
                  <img src="pics/imgs/airbp.png" class=".img-responsive .center-block" alt="AirBP" width="350px"/>
                </a>
              </div>
              <div class="row text-center">
                <h2>AirBP</h2>
              </div>
            </div>
          </table>
        </td>
      </tr>

    </div>
  </div>


  <div class="container">
    <div class="modal-footer">
      <ul class="list-unstyled text-right">
      <li>联系我们：</li>
      <li>深圳源动创新科技有限公司</li>
      <li>marketing@viatomtech.com</li>
      <li>0755-86638929</li>
      </ul>
    </div>
  </div>

  <div class="container">

    <div class="modal-footer">
      <ul class="list-inline text-left">
      <li>© 2018 Viatom Technology co., ltd. All rights reserved. </li>
      <li><a href="http://www.miitbeian.gov.cn/">粤ICP备15110766号-1</a></li>
      <li><a href="https://www.viatomtech.com.cn">www.viatomtech.com.cn</a></li>
      </ul>
    </div>
  </div>
  
</body>
</html>