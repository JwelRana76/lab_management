
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="" />
    <title>Lab Report</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
   <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bellefair&family=Kalam&family=Lobster&family=Trocchi&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kalam&family=Lobster&display=swap" rel="stylesheet">
    <style>
        * {
            line-height: 16px;
            font-size:18px !important;
            
        }
        .btn {
            padding: 7px 10px;
            text-decoration: none;
            border: none;
            display: block;
            text-align: center;
            margin: 7px;
            cursor:pointer;
        }

        .btn-info {
            background-color: #999;
            color: #FFF;
        }

        .btn-primary {
            background-color: #6449e7;
            color: #FFF;
            width: 100%;
        }

        /*tr {border-bottom: 1px dotted #ddd;}*/
        /*.details_table td {padding: 7px 0;*/
        /*    border:1px solid black;*/
        /*    border-collapse: collapse;*/
            
        /*}*/
        .details_table th {
          border: 1px solid;
          font-size:16px !important;
          padding:5px 5px;
        }
        .patient_info{
            border:1px solid black;
            justify-content:space-between;
        }
        .patient_info p{
            font-size:14px;
            display:inline-block;
            padding:0;
            margin:0;
        }
        .details_table {
          width: 100%;
          border-collapse: collapse;
        }
        /*tbody, tbody tr, tbody td {*/
        /*    border-collapse: collapse;*/
        /*    border:1px solid black;*/
        /*}*/
        .text-center{
            text-align:center;
        }
        table {width: 100%;}
        tfoot tr th:first-child {text-align: left;}

        .centered {
            text-align: center;
            align-content: center;
        }
        .mr-5{
            margin-right:50px;
        }
        .bordered th{
            border: 1px solid;
        }
        .bordered{
            border-collapse: collapse;
        }
        div.divFooter {
            display:none;
          }
        .w-25{
            width:25%;
        }
        
        .other_test td{
            font-size: 18px !important;
        }
        .other_test span{
            font-size: 18px !important;
        }
        .patient_info_left{
            width:70%;
        }
        .urine_test span{
            font-size:13px !important;
        }
        .urine_test h6{
            font-size:14px !important;
        }
        .urine_test td{
          padding:1px 2px !important;
        }
        small{font-size:11px;}

        @media  print {
            * {
                font-size:13px;
                margin:0;
                padding:0;
                box-sizing:border-box;
            }
            h4{
                font-size:18px !important;
                font-weight:500 !important;
            }
            .patient_info p{
                font-size:22px important;
                display:inline-block;
                padding:2px;
                margin:0;
            }
            
            div.divFooter {
                display:block;
                position: fixed;
              bottom: 20px;
              left: 30px;
              right: 0;
              }
            td,th {padding: 5px 0;}
            .hidden-print {
                display: none !important;
            }
            .text-center{
                text-align:center;
            }
            td{
                line-height:22px;
            }
            .details_table{
                font-size:10px !important;
            }
            .text-right{
                text-align:right;
            }
            .divFooter .mr-50{
                margin-right:50px;
            }
            .text-left{
                text-align:center;
            }
            .mr-5{
                margin-right:50px;
            }
            
            .w-50{
                width:50%;
            }
            .w-25{
                width:25%;
            }
            .w-40{
                width:40%;
            }
            .w-30{
                width:30%;
            }
            .other_test td{
                font-size: 18px !important;
            }
            .other_test span{
                font-size: 18px !important;
            }
            .urine_test span{
                font-size:13px !important;
            }
            @page  { margin: 0; } body { margin: 0.5cm; margin-bottom:1.6cm; }
            
        }
        .info{
            display:flex;
        }
        
    </style>
  </head>
<body>
@php
  foreach($tests as $test_id){
      $ptest = App\Models\PathologyTest::findOrFail($test_id);
      $specimen = "Blood";
      if($ptest->specimen != null)
        $specimen = $ptest->specimen;
  }
@endphp
<div style="max-width: 750px;;margin:0 auto">
    <div class="hidden-print">
        <table>
            <tr>
                <td><button onclick="window.print();" class="btn btn-primary"><i class="fa fa-print"></i> Print</button></td>
            </tr>
        </table>
        <br>
    </div>

    <div id="receipt-data">
        <div style="height:150px">
            
        </div>
        
        
        <div class="patient_info" style="padding:2px 5px">
            <div class="info">
                <div class="patient_info_left">
                    <p>ID No : <span>{{$patient->unique_id ?? null}}</span></p></br>
                    <p>Patient : <span>{{$patient->name ?? null}}</span></p></br>
                </div>
                <div class="patient_info_right">
                    <p>Date : <span>{{$patient->updated_at->format('d-M-Y h:s:i') ?? null}}</span></p></br>
                    <p>Age : <span>{{$patient->age ?? null}}</span>,</p>
                    <p>Sex : <span>{{$patient->gender->name ?? null}}</span></p>
                </div>
            </div>
            <div>
                <p>Refd. By. : <span style="font-size:16px">{{$patient->doctor->name??$patient->referral->name ?? 'Self'}}</span></p></br>
                <p>Specimen : {{ $specimen }} <span></p>
            </div>
        </div>
        @foreach($pathology_test as $key=>$category)
            @php
              $patient_test = App\Models\PathologyTest::join('patient_tests','patient_tests.test_id','pathology_tests.id')
                    ->where('pathology_tests.pathology_test_category_id',$category)
                    ->where('patient_tests.patient_id',$patient->id)
                    ->whereIn('patient_tests.test_id', $tests)
                    ->get();
                
              $test_category = App\Models\PathologyTestCategory::findOrFail($category);
              $urin = 1;
            @endphp
            <h5 class="text-center text-bold"  style="margin-bottom:0px;margin-top:40px"><u><b>{{ $test_category->name }}</b></u></h5>
            <h6 class="text-center" style="margin-top:10px;font-size:16px !important">{{ $test_category->sub_category }}</h6>
        
        @foreach($patient_test as $keeys=>$patienttest)
        @php
            $setup = App\Models\PathologyTestSetup::join('pathology_test_setup_results','pathology_test_setup_results.pathology_test_setup_id','pathology_test_setups.id')
                    ->where('pathology_test_setups.test_id',$patienttest->test_id)
                    ->get();
        @endphp
            <p style="margin-top:20px !important"></p>
            {{-- @foreach($setup as $key=>$item) --}}
                
                @php
                    $result = App\Models\PathologyPatientReport::join('pathology_patient_report_values','pathology_patient_report_values.report_id','pathology_patient_reports.id')
                            ->join('pathology_test_setup_results','pathology_test_setup_results.result_id','pathology_patient_report_values.result_id')
                            ->where('pathology_patient_reports.patient_id',$patient->id)
                            ->where('pathology_patient_reports.test_id',$patienttest->test_id)
                            ->get();
                @endphp
                @if($ptest->code == 9147)
                <table class="table urine_test details_table"  style="margin:0px">
                    @if($urin == 1)
                        <thead style="text-align:left">
                            <tr>
                                <th class="w-50">Test Name</th>
                                <th class="w-25">Result</th>
                                @if($item->is_normal_value == 1)
                                <th>Normal Value</th>
                                @endif
                            </tr>
                        </thead>
                        @php
                        $urin = 2;
                        @endphp
                    @endif
                    <tbody  style="margin:5px">
                        <tr>
                            <td colspan="2"><h6 style="margin:0px;font-size:14px">{{find_heading($item->heading_id)->name ?? null}}</h6></td>
                        </tr>
                       @foreach($result as $res)
                             @php
                                $result_set = App\Models\Pathology\PathologyTestSetupResult::find($res->id);
                                $result_value = App\Models\Pathology\PathologyReport::where(['patient_id'=>$patient->id,'test_id'=>$test])
                                    ->join('pathology_report_types','pathology_report_types.pathology_report_id','pathology_reports.id')
                                    ->select('pathology_report_types.*')->first();
                                $keys++;
                                if($pathology_report[$keys]->is_converted == 1){
                                    if($pathology_report[$keys]->calculate_operator == '*'){
                                        $convert_value = ($pathology_report[$keys]->result_value * 1) * $pathology_report[$keys]->calculation_value;
                                    }elseif($result_set->calculate_operator == '/'){
                                        $convert_value = $pathology_report[$keys]->result_value / $pathology_report[$keys]->calculate_value;
                                    }elseif($result_set->calculate_operator == '+'){
                                        $convert_value = $pathology_report[$keys]->result_value + $pathology_report[$keys]->calculate_value;
                                    }elseif($result_set->calculate_operator == '-'){
                                        $convert_value = $pathology_report[$keys]->result_value - $pathology_report[$keys]->calculate_value;
                                    }else{
                                        $convert_value = $pathology_report[$keys]->result_value % $pathology_report[$keys]->calculate_value;
                                    }
                                }
                                if($result_set->result_type == 1){
                                    $result = $pathology_report[$keys]->result_value;
                                }else{
                                    if($pathology_report[$keys]->result_value == 1){
                                        $result = "Positive";
                                    }else{
                                        $result = "Negative";
                                    }
                                }   
                            @endphp
                            <tr  style="margin:0px">
                                <td class="w-50" style="margin:0px"><span class="mr-5">{{$result_set->result->name}}</span></td> 
                                <td class="w-25" style="margin:0px"> <span class="mr-5">{{$result}} {{find_unit($result_set->unit_id)->name ?? null}}</span> 
                                    <span> {{$result_set->is_converted == 1 ? $convert_value:''}}{{find_unit($result_set->convert_unit)->name ?? null}}</span></td>
                                    
                                @if($is_normal_value == 1)
                                <td class="w-25 style="margin:0px"">{{$result_set->normal_value ?? null}}</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <table class="table other_test details_table"  style="margin:0px">
                    @if($keeys == 0)
                        <thead style="text-align:left">
                            <tr>
                                <th class="w-50">Test Name</th>
                                <th class="w-25">Result</th>
                                @if($result[0]->normal_value != null)
                                <th>Normal Value</th>
                                @endif
                            </tr>
                        </thead>
                    @endif
                    <tbody  style="margin:0px">
                        @foreach($result as $key=>$res)
                            @php
                                $result_name = App\Models\PathologyResultName::findOrFail($res->result_id);
                                if ($res->pathology_unit_id != null) {
                                    $unit = App\Models\PathologyUnit::findOrFail($res->pathology_unit_id);
                                }else{
                                    $unit = null;
                                }
                                if ($res->pathology_convert_unit_id != null) {
                                    $convert_unit = App\Models\PathologyUnit::findOrFail($res->pathology_convert_unit_id);
                                }else{
                                    $convert_unit = null;
                                }
                                
                            @endphp
                            <tr  style="margin:0px">
                                <td class="w-40" style="margin:0px"><span class="mr-5">{{$result_name->name ?? null}}</span></td> 
                                <td class="w-30" style="margin:0px"> <span class="mr-5">{{$res->result_value}} {{ $unit->name ??null }} </span> 
                                    <span> {{$res->is_converted == 1 ? $res->convert_value:''}} {{ $convert_unit->name ??null }}</span></td>
                                    
                                @if($result[0]->normal_value != null)
                                <td class="w-30" style="margin:0px">{{$res->normal_value ?? null}}</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            {{-- @endforeach --}}
        @endforeach
       
        @endforeach
    </div>
   <div class="divFooter" style="float:right">
       <div class="col-md-6">
           <table class="table">
               <tr style="margin-bottom:0px">
                   <td class="mr-50"> Checked By.</td>
                   <td style="width:300px"></td>
                   <td style="line-height:18px"><b>MD. ABU SAYED</b> <br>
                   DMT ( NMI) Dinajpur  FT ( RpMCH)<br>
                   Medical Technologist Lab <br>
                   ENT Care & Audiology <br>
                   Center: Saidpur, Nilphamari
                   </td>
               </tr>
               <tr>
                   <td></td>
                   <td></td>
                   <td>
                   </td>
               </tr>
           </table>
       </div>
   </div>
</div>

<script type="text/javascript">
    function auto_print() {
      //  window.print()
    }
    setTimeout(auto_print, 1000);
</script>

</body>
</html>
