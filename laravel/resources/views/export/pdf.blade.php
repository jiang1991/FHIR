<!DOCTYPE html>
<html>
<head>
  <title>Sleep PDF export</title>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <style type="text/css">
    .text_info {
      /*font-weight: bold;*/
      /*padding-right: 40px;*/
      padding-bottom: 10px;
    }
    .text_record {
      margin-left: 150px;
      padding-bottom: 10px;
    }
    .report {
      width: 850px;
      font-size: 50px;
      font-weight: bold;
    }
    .content_table {
      margin-top: 40px;
      /*padding-left: 60px;*/
      /*padding-right: 60px;*/
      width: 1000px;
    }
    .info_table {
      width: 1000px;
      margin-top: 20px;
      /*padding: 20px;*/
      border: 1px solid #555;
    }
    .patient {
      margin-left: 20px;
      padding-top: 20px;
      padding-bottom: 20px;
    }
    .dividing{
      border-top-style: dotted;
      border-width: 1px;
      border-color: #555;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <table align="center" class="content_table">
    <!-- header  -->
    <tr>
      <td class="report">
          Sleep Report
      </td>
      <td>
        <img width="150px" src="/var/www/cloud/storage/app/viatom-logo.png">
      </td>
    </tr>
  </table>

  <table align="center"  class="info_table">
    <!-- patient info -->
    <tr>
      <td>
        <table class="patient">
          <tr>
            <td>
              <strong>Name : </strong> {{ $patient->name }}
            </td>
            <td>
              <strong>Medical ID : </strong> {{ $patient->medicalId }}
            </td>
          </tr>
          <tr>
            <td>
              <strong>Gender : </strong> {{ $patient->gender }}
            </td>
            <td>
              <strong>Birth date : </strong> {{ date('M d, Y', strtotime($patient->birthDate)) }}
            </td>
          </tr>
          <tr>
            <td>
              <strong>Height : </strong> {{ $patient->height }}
            </td>
            <td>
              <strong>Weight : </strong> {{ $patient->weight }}
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td>
        <table>
          <tr>
            <td>
              @foreach ($observation_components as $observation_component)
                @if (!$observation_component->valueString)
                <div class="text_record">
                  <strong>{{ $observation_component->code_display }} : </strong> {{ $observation_component->valueQuantity_value }} {{ $observation_component->valueQuantity_unit }}
                </div>
                
                @endif
              @endforeach
            </td>
          </tr>
        </table>  
      </td>
    </tr>
  </table>
    
  <table align="center" width="1100px">
    <!-- img -->
    <tr>
      <td>
      @foreach ($observation_components as $observation_component)
        @if ($observation_component->valueString)
        <img width="1100px" src="/var/www/cloud/storage/images/{{ $observation_component->id }}.png">
        @endif
      @endforeach
      </td>
    </tr>
  </table>
</body>
</html>
