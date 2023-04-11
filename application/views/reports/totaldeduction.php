<script>
  function printDiv() {

    var divToPrint = document.getElementById('divToPrint');
    var WindowObject = window.open('', 'Print-Window');
    WindowObject.document.open();
    WindowObject.document.writeln('<!DOCTYPE html>');
    WindowObject.document.writeln('<html><head><title></title><style type="text/css">');
    WindowObject.document.writeln('@media print { .center { text-align: center;} .underline { text-decoration: underline; } p { display:inline; } .left { margin-left: 315px; text-align="left" display: inline; } .right { margin-right: 375px; display: inline; } td.left_algn { text-align: left; } td.right_algn { text-align: right; } .t2 td, th { border: 1px solid black; } td.hight { hight: 15px; } table.width { width: 100%; } table.noborder { border: 0px solid black; } th.noborder { border: 0px solid black; } .border { border: 1px solid black; } .bottom { position: absolute; bottom: 5px; width: 100%;} .payslip_logo_Desc_Uts h3{font-size: 18px; margin: 0 0 6px 0; font-family: "Roboto", sans-serif;} .payslip_logo_Desc_Uts h4{font-size: 14px; margin: 0 0 5px 0; font-family: "Roboto", sans-serif;}  table.table_1_Uts{font-family: "Roboto", sans-serif; font-size: 14px;}  table.table_1_Uts{font-family: "Roboto", sans-serif; font-size: 14px;} .payslip_logo_Uts{float:left; max-width: 16.66667%; padding-right:15px;} .payslip_logo_Desc_Uts{float:left; max-width: 83.33333%;} table.payslipTable_Uts tbody tr td {font-size: 13px; padding:5px 15px;} .table_1_Uts{width:100%;} .table_1_Uts td td{padding:2px 15px;} .table_2_Uts td td{padding:2px 15px;} .table_1_Uts{font-family: "Roboto", sans-serif; font-size: 13px;} .table_2_Uts{font-family: "Roboto", sans-serif; font-size: 13px;} } </style>');
    WindowObject.document.writeln('</head><body onload="window.print()">');
    WindowObject.document.writeln(divToPrint.innerHTML);
    WindowObject.document.writeln('</body></html>');
    WindowObject.document.close();
    setTimeout(function() {
      WindowObject.close();
    }, 10);

  }
</script>

<style>
  th {
    text-align: center;
    vertical-align: middle !important;
  }
</style>

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $tot_pf = 0;
  $tot_loan_prin = 0;
  $tot_loan_int = 0;
  $tot_p_tax = 0;
  $tot_income_tax_tds = 0;
  $tot_security = 0;
  $tot_insurance = 0;
  $tot_tot_diduction = 0;
?>
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="card">
        <div class="card-body" id='divToPrint'>
          <div class="row">
            <div class="col-2 payslip_logo_Uts"><a href="javascript:void()"><img src="<?= base_url() ?>assets/images/benfed.png" alt="logo" /></a></div>
            <div class="col-10 payslip_logo_Desc_Uts">
              <h3>Puri Urban & Rural Development Co-Operative Society Ltd.</h3>
              <h4>Puri NEAR (JYOTI HOTEL) GRAND ROAD, PURI-752001</h4>
              <h4>Govt. Regd. No. 193/54/PURI</h4>
              <h4>Total deduction of Regular employees From <?php echo date('d/m/Y', strtotime($this->input->post('from_date'))) . ' To ' . date('d/m/Y', strtotime($this->input->post('to_date'))); ?>
              </h4>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th rowspan="2">Sl No.</th>
                      <th rowspan="2">Name of Emplyees</th>
                      <th rowspan="2">Provident Fund</th>
                      <th colspan="2">Loan</th>
                      <th rowspan="2">Prof. Tax</th>
                      <!-- <th rowspan="2">G.I.C.I.</th> -->
                      <th rowspan="2">Income Tax TDS</th>
                      <th rowspan="2">Security</th>
                      <th rowspan="2">Insurance</th>
                      <th rowspan="2">Total <br>Deduction</th>
                    </tr>
                    <tr>
                      <th>Prin.</th>
                      <th>Int.</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                    if ($total_deduct) {

                      $i  =   1;

                      $tot_ins = $tot_css = $tot_hbl = $tot_tel = $tot_med_adv = $tot_fa = $tot_tf = $tot_med_ins = $tot_comp_loan = $tot_ptax = $tot_itax = $tot_gpf = $tot_epf = $tot_other_deduction = 0;

                      foreach ($total_deduct as $td_list) {

                        $tot_pf += $td_list->pf;
                        $tot_loan_prin += $td_list->loan_prin;
                        $tot_loan_int += $td_list->loan_int;
                        $tot_p_tax += $td_list->p_tax;
                        // $tot_gici += $td_list->gici;
                        $tot_income_tax_tds += $td_list->income_tax_tds;
                        $tot_security += $td_list->security;
                        $tot_insurance += $td_list->insurance;
                        $tot_tot_diduction += $td_list->tot_diduction;
                    ?>

                        <tr>

                          <td><?= $i++; ?></td>

                          <td><?= $td_list->emp_name; ?></td>
                          <td><?= $td_list->pf; ?></td>
                          <td><?= $td_list->loan_prin; ?></td>
                          <td><?= $td_list->loan_int; ?></td>
                          <td><?= $td_list->p_tax; ?></td>
                          <!-- <td><?php //echo $td_list->gici; 
                                    ?></td> -->
                          <td><?= $td_list->income_tax_tds; ?></td>
                          <td><?= $td_list->security; ?></td>
                          <td><?= $td_list->insurance; ?></td>
                          <td><?= $td_list->tot_diduction; ?></td>
                        </tr>

                      <?php

                      }

                      ?>


                      <tr>

                        <td colspan="2">Total Amount</td>
                        <td><?= $tot_pf; ?></td>
                        <td><?= $tot_loan_prin; ?></td>
                        <td><?= $tot_loan_int; ?></td>
                        <td><?= $tot_p_tax; ?></td>
                        <td><?= $tot_income_tax_tds; ?></td>
                        <td><?= $tot_security; ?></td>
                        <td><?= $tot_insurance; ?></td>
                        <td><?= $tot_tot_diduction; ?></td>
                      </tr>

                    <?php

                    } else {

                      echo "<tr><td colspan='9' style='text-align:center;'>No Data Found</td></tr>";
                    }
                    ?>

                  </tbody>

                </table>
                <br>
                <div>

                </div>

                <div class="bottom">

                  <p style="display: inline;">Prepared By</p>

                  <p style="display: inline; margin-left: 8%;">Establishment, Sr. Asstt.</p>

                  <p style="display: inline; margin-left: 8%;">Assistant Manager-II</p>

                  <p style="display: inline; margin-left: 8%;">Chief Executive officer</p>

                </div>


              </div>
            </div>
          </div>
        </div>
      </div>
      <center>
        <button type='button' class="btn btn-warning text-white mt-3" onclick='printDiv();'>Print</button>
      </center>
    </div>



  <?php
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  ?>

    <div class="main-panel">
      <div class="content-wrapper">
        <div class="card">
          <div class="card-body">
            <h3>Deduction Report</h3>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <form method="POST" id="form" action="<?php echo site_url("reports/totaldeduction"); ?>">
                      <div class="form-group">
                        <div class="row">
                          <div class="col-6">
                            <label for="exampleInputName1">From Date:</label>
                            <input type="date" name="from_date" class="form-control required" id="from_date" value="<?php echo $sys_date; ?>" />
                          </div>
                          <div class="col-6">
                            <label for="exampleInputName1">To Date:</label>
                            <input type="date" name="to_date" class="form-control required" id="to_date" value="<?php echo $sys_date; ?>" />


                          </div>
                        </div>
                      </div>

                      <input type="submit" class="btn btn-warning text-white" value="Proceed" />
                      <button class="btn btn-light">Cancel</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    <?php

  } else {

    echo "<h1 style='text-align: center;'>No Data Found</h1>";
  }

    ?>