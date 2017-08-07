<title>
  Example 1 - apply dataTable()</title>



  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs-3.3.7/jq-2.2.4/dt-1.10.15/af-2.2.0/b-1.3.1/b-colvis-1.3.1/b-print-1.3.1/cr-1.3.3/r-2.1.1/rr-1.2.0/sc-1.4.2/datatables.min.css"/>

<script type="text/javascript" src="https://cdn.datatables.net/v/bs-3.3.7/jq-2.2.4/dt-1.10.15/af-2.2.0/b-1.3.1/b-colvis-1.3.1/b-print-1.3.1/cr-1.3.3/r-2.1.1/rr-1.2.0/sc-1.4.2/datatables.min.js"></script>

</head>

<body>
  <div class="container">

    <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>2011/04/25</td>
                <td>$320,800</td>
            </tr>
            

        </tbody>
    </table>

  </div>
</body>
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
} );


</script>
