@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="container">

      <!-- breadcrumb -->
      <ul class="breadcrumb">
        <li><a href="/">Home</a> <span class="divider"></span></li>
        <li class="active">Terms</li>
      </ul>

      <!-- page header -->
      <div class="page-header">
        <h1>Terms</h1>
      </div>

      <!-- language choose -->

      <ul id="myTabs" class="nav nav-tabs" role="tablist">
        <li role="presentation" class="dropdown active">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                Language <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="#dropdown_en" role="tab" id="dropdown_en-tab" data-toggle="tab" aria-controls="dropdown_en" aria-expanded="false">English</a></li>
            <li><a href="#dropdown_ch" role="tab" id="dropdown_ch-tab" data-toggle="tab" aria-controls="dropdown_ch" aria-expanded="false">Chinese</a></li>
            <li><a href="#dropdown_fr" role="tab" id="dropdown_fr-tab" data-toggle="tab" aria-controls="dropdown_fr" aria-expanded="false">French</a></li>
            <li><a href="#dropdown_es" role="tab" id="dropdown_es-tab" data-toggle="tab" aria-controls="dropdown_es" aria-expanded="false">Spanish</a></li>

         </ul>
        </li>
      </ul>

      <div id="myTabContent" class="tab-content">
        <div role="tabpanel" class="tab-pane fade active in" id="dropdown_en" aria-labelledby="dropdown_en-tab">
          <p>I am english text</p>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="dropdown_ch" aria-labelledby="dropdown_ch-tab">
          <p>I am chinese text</p>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="dropdown_fr" aria-labelledby="dropdown_fr-tab">
          <p>I am french text</p>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="dropdown_es" aria-labelledby="dropdown_es-tab">
          <p>I am spanish text</p>
        </div>
      </div>


      <!-- page -->

      

      <h3>
        THIS NOTICE DESCRIBES HOW MEDICAL INFORMATION ABOUT YOU MAY BE USED AND DISCLOSED AND HOW YOU CAN GET ACCESS TO THIS INFORMATION. PLEASE REVIEW IT CAREFULLY.
      </h3>
      <p>
        St Cloud Medical Group is required by law to maintain the privacy of your protected health information. St Cloud Medical Group is required to provide you with a notice that describes St Cloud Medical Group’s legal duties, privacy practices, and your privacy rights with respect to your protected health information. We will follow the privacy practices described in this notice that are currently in effect.
        We reserve the right to change the terms of our privacy practices described in this notice in the event that the practices need to be changed to be in compliance with the law. We will make the new notice provisions effective for all the protected health information that we maintain. If we change our privacy practices, a current version will be posted in public areas of the clinic, available on our website or on paper from a Receptionist.
        This Notice of Privacy Practices describes how we may use and disclose your protected health information to carry out treatment, payment, or health care operations as defined by HIPAA and for other purposes that are permitted or required by law. It also describes your rights to access and control your protected health information. “Protected health information” is information about you including demographic information that may identify you and that relates to your past, present or future physical or mental health conditions and related health care services.
      </p>

    </div>
    
  </div>
</div>
@endsection
