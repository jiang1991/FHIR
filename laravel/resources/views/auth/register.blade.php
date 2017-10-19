@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">Register</div>
        <div class="panel-body">
          <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              <label for="name" class="col-md-4 control-label">Name</label>

              <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">

                @if ($errors->has('name'))
                  <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                  </span>
                @endif
              </div>
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              <label for="email" class="col-md-4 control-label">Email</label>

              <div class="col-md-6">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                @if ($errors->has('email'))
                  <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                  </span>
                @endif
              </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              <label for="password" class="col-md-4 control-label">Password</label>

              <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password">

                @if ($errors->has('password'))
                  <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                  </span>
                @endif
              </div>
            </div>

            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
              <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

              <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                @if ($errors->has('password_confirmation'))
                  <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                  </span>
                @endif
              </div>
            </div>

            <!-- <div class="form-group{{ $errors->has('eula_check') ? ' has-error' : '' }}">
              <div class="col-md-6 col-md-offset-4">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="eula_check"> I agree to the Viatom <a href="{{ url('/terms') }}">Terms</a>
                  </label>
                </div>
              </div>
            </div> -->

            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#eulaModal">
                  <i class="fa fa-btn fa-user"></i> Sign up
                </button>
              </div>
            </div>

            <!-- eula modal -->
            <div class="modal fade" id="eulaModal" tabindex="-1" role="dialog" aria-labelledby="eualModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Non-medical use statement</h4>
                  </div>

                  <div class="modal-body">
                    <ul id="myTabs" class="nav nav-tabs" role="tablist">
                      <li role="presentation" class="dropdown active">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                              Language <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                          <li><a href="#dropdown_en" role="tab" id="dropdown_en-tab" data-toggle="tab" aria-controls="dropdown_en" aria-expanded="false">English</a></li>
                          <li><a href="#dropdown_ch" role="tab" id="dropdown_ch-tab" data-toggle="tab" aria-controls="dropdown_ch" aria-expanded="false">Chinese</a></li>
                          <li><a href="#dropdown_fr" role="tab" id="dropdown_fr-tab" data-toggle="tab" aria-controls="dropdown_fr" aria-expanded="false">French</a></li>
                          <!-- <li><a href="#dropdown_es" role="tab" id="dropdown_es-tab" data-toggle="tab" aria-controls="dropdown_es" aria-expanded="false">Spanish</a></li> -->

                       </ul>
                      </li>
                    </ul>

                    <div id="myTabContent" class="tab-content">
                      <!-- English Part -->
                      <div role="tabpanel" class="tab-pane fade active in" id="dropdown_en" aria-labelledby="dropdown_en-tab">
                        <p>If it's critical to know your health, we recommend that you find out from that Medical Practitioner how the Medical Practitioner handles your personal information. Viatom is not intended to diagnose, prevent or treat any condition, or to be a substitute for professional medical care. Measurements and statistics are intended for informational and educational purposes only.</p>
                      </div>

                      <!-- Chinese part -->
                      <div role="tabpanel" class="tab-pane fade" id="dropdown_ch" aria-labelledby="dropdown_ch-tab">
                        <p>如果了解您的健康状况至关重要，我们建议您从该医生处了解医生如何处理您的个人信息。Viatom 不是用于诊断，预防或治疗任何病症，也不能替代专业医疗。 测量和统计仅供参考和教育目的。</p>
                      </div>

                      <!-- French part -->
                      <div role="tabpanel" class="tab-pane fade" id="dropdown_fr" aria-labelledby="dropdown_fr-tab">
                        <p>S'il est essentiel de connaître votre santé, nous vous recommandons de découvrir auprès de ce Médecin comment le médecin traitant vos renseignements personnels. Viatom ne vise pas à diagnostiquer, à prévenir ou à traiter une condition ou à remplacer les soins médicaux professionnels. Les mesures et les statistiques sont uniquement destinées à des fins d'information et d'éducation.</p>
                      </div>

                      <!-- Spanish part -->
                      <!-- <div role="tabpanel" class="tab-pane fade" id="dropdown_es" aria-labelledby="dropdown_es-tab">
                        <p>I am spanish text</p>
                      </div> -->
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Agree and Sign up</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                  <i class="fa fa-btn fa-user"></i> Sign up
                </button>
              </div>
            </div> -->
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
