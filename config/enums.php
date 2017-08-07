
<?php
return [


    'QuickVali' => [
        'fk' => 'numeric|required',
        'money'=>'regex:/^\d*(\.\d{1,2})?$/',
        'nic'=>'required|regex:/^[0-9]{9}$/',
        'tel'=>'regex:/^[0-9]{10}$/',
        'precentage'=>'between:0,99.99',
        'time'=>"regex:/(1[012]|0[0-9]):([0-5][0-9])/",
        'important_date' => 'date|required',




        // etc
    ]




];
?>
