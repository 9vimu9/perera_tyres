<?php
function slip_creator($slip,$allowences,$deductions,$demos)
{

  $slip_feature_demos=PrintFeature($slip,2);
  $slip_feature_allowences=PrintFeature($slip,1);
  $slip_feature_deductions=PrintFeature($slip,0);//slip,feature_type

  $basic_salary=$slip->basic_salary+$slip->salary->budget_allowence;
  $ot_rate=$slip->ot_available==1 ? $slip->ot_rate : 'no OT' ;
  $ot_hours=get_ot_hours_all($slip->salary,$slip->employee);
  $ot_in_rs=get_ot_in_rs($slip->salary,$slip->employee,$slip->ot_rate);


  $no_pay_in_rs=0;
  $total_earning_in_rs=$slip_feature_allowences[1]+$ot_in_rs+$basic_salary;
  $total_deductions_in_rs=$slip_feature_deductions[1]+$no_pay_in_rs;
  $total_salary=$total_earning_in_rs-$total_deductions_in_rs-$no_pay_in_rs;

$allowence_list="";
foreach ($allowences as $allowence){
    foreach ($slip_feature_allowences[0] as $slip_feature_allowence){
      if ($slip_feature_allowence['feature_id']==$allowence->id){
        $allowence_list=$allowence_list."<p>".get_feature_column_header($allowence)." : <strong> Rs".$slip_feature_allowence['value_in_rs']."</strong></p>";
      }
    }
}

$deduction_list="";
foreach ($deductions as $deduction){
    foreach ($slip_feature_deductions[0] as $slip_feature_deduction){
      if ($slip_feature_deduction['feature_id']==$deduction->id){
        $deduction_list=$deduction_list."<p>".get_feature_column_header($deduction)." : <strong> Rs".$slip_feature_deduction['value_in_rs']."</strong></p>";
      }
    }
}


  $html= "
  <table>
    <tr>
      <td>
        <h4 >PERERA TYRE SERVICES</h4>
        <p >address 1</p>
        <p >tel 1</p>
      </td>
    </tr>
    <tr>
      <td>
        <h4>PAY SLIP for<strong> ".date("F", mktime(0, 0, 0, $slip->salary->month, 10)).",".$slip->salary->year."</strong></h4>
        <p>(".$slip->salary->start_date." to ".$slip->salary->end_date.")</p>
        <h4><strong>".$slip->employee->name." , ".$slip->employee->designation->name."</strong></h4>
        <p >basic salary : <strong>Rs".$basic_salary."</strong></p>
        <p>OT : Rs ".$ot_in_rs."</p>
        <p>No pay : Rs ".$no_pay_in_rs."</p>
        <p>days worked :".worked_days_in_salary_month($slip->employee,$slip->salary)."</p>
      </td>
    </tr>
    <tr>
      <td>
        <div class='row'>
            <h5><strong>ALLOWENCES</strong></h5>"
            .$allowence_list.
            "<h5><strong>total allowence: Rs ".$slip_feature_allowences[1]."</strong></h5>
        </div>
      </td>
    </tr>
    <tr>
      <td>
        <div class='row'>
          <h5><strong>DEDUCTIONS</strong></h5>"
          .$deduction_list.
          "<p><strong>total deduction: Rs ".$slip_feature_deductions[1]."</strong></p>
        </div>
      </td>
    </tr>
    <tr>
      <td>
        <div class='row'>
          <p><h3><strong>Net Salary : ".$total_salary."</strong></h3></p>
        </div>
      </td>
    </tr>
  </table>
  ";
  echo $html;
}
?>
