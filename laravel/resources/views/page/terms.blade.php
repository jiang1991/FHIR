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
            <!-- <li><a href="#dropdown_es" role="tab" id="dropdown_es-tab" data-toggle="tab" aria-controls="dropdown_es" aria-expanded="false">Spanish</a></li> -->

         </ul>
        </li>
      </ul>

      <div id="myTabContent" class="tab-content">
        <!-- English Part -->
        <div role="tabpanel" class="tab-pane fade active in" id="dropdown_en" aria-labelledby="dropdown_en-tab">
          <h3 class="text-capitalize">Non-medical use statement</h3>
          <p>If it's critical to know your health, we recommend that you find out from that Medical Practitioner how the Medical Practitioner handles your personal information. Viatom is not intended to diagnose, prevent or treat any condition, or to be a substitute for professional medical care. Measurements and statistics are intended for informational and educational purposes only.</p>
        </div>

        <!-- Chinese part -->
        <div role="tabpanel" class="tab-pane fade" id="dropdown_ch" aria-labelledby="dropdown_ch-tab">
          <h3>警告： 不能用于医疗用途</h3>
          <p>如果了解您的健康状况至关重要，我们建议您从该医生处了解医生如何处理您的个人信息。Viatom 不是用于诊断，预防或治疗任何病症，也不能替代专业医疗。 测量和统计仅供参考和教育目的。</p>
        </div>

        <!-- French part -->
        <div role="tabpanel" class="tab-pane fade" id="dropdown_fr" aria-labelledby="dropdown_fr-tab">
          <h3>Déclaration d'utilisation non médicale</h3>
          <p>S'il est essentiel de connaître votre santé, nous vous recommandons de découvrir auprès de ce Médecin comment le médecin traitant vos renseignements personnels. Viatom ne vise pas à diagnostiquer, à prévenir ou à traiter une condition ou à remplacer les soins médicaux professionnels. Les mesures et les statistiques sont uniquement destinées à des fins d'information et d'éducation.</p>
        </div>

        <!-- Spanish part -->
        <!-- <div role="tabpanel" class="tab-pane fade" id="dropdown_es" aria-labelledby="dropdown_es-tab">
          <p>I am spanish text</p>
        </div> -->
      </div>

    </div>
    
  </div>
</div>
@endsection
