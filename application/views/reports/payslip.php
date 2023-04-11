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

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($payslip_dtls)) {
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
                            <h4>Pay Slip for <?php echo MONTHS[$this->input->post('sal_month')] . '-' . $this->input->post('year'); ?></h4>
                            <!-- <h4><?php echo $payslip_dtls->emp_name; ?></h4> -->

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="order-listing" class="table table_1_Uts">
                                    <thead>
                                        <tr>
                                            <th class="noborder" width="25%"></th>
                                            <th class="noborder" width="1%"></th>
                                            <th class="noborder" width="25%"></th>
                                            <th class="noborder" width="1%"></th>
                                            <th class="noborder" width="30%"></th>
                                            <th class="noborder" width="1%"></th>
                                            <th class="noborder" width="20%"></th>
                                            <th class="noborder" width="20%"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="payslipTbodyFast_Uts">

                                        <tr>
                                            <td>Employee Code
                                                <!-- <td></td> -->
                                            <td class="left_algn">:</td>
                                            <td><?php echo $payslip_dtls->emp_code; ?></td>
                                            <td></td>
                                            <td>Employee Name</td>
                                            <td class="left_algn">:</td>
                                            <td class="left_algn"><?php echo $payslip_dtls->emp_name; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Designation</td>
                                            <td class="left_algn">:</td>
                                            <td><?php echo $payslip_dtls->designation; ?></td>
                                            <td></td>
                                            <td>Department</td>
                                            <td class="left_algn">:</td>
                                            <td class="left_algn"><?php echo $payslip_dtls->department; ?></td>

                                        </tr>
                                        <tr>
                                            <td>Sal Structure</td>
                                            <td class="left_algn">:</td>
                                            <td class="left_algn">PURDCS, LTD</td>
                                            <td></td>
                                            <td>Date of Joining</td>
                                            <td class="left_algn">:</td>
                                            <td class="left_algn"><?= date_format(date_create($emp_dtls->join_dt), 'd-m-Y') ?></td>
                                        </tr>
                                        <tr>
                                            <td>Pan No</td>
                                            <td class="left_algn">:</td>
                                            <td><?php echo $payslip_dtls->pan_no; ?></td>
                                            <td></td>
                                            <td>Date of Birth</td>
                                            <td class="left_algn">:</td>
                                            <td><?= date_format(date_create($emp_dtls->dob), 'd-m-Y'); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Bank A/C No</td>
                                            <td class="left_algn">:</td>
                                            <td class="left_algn"><?php echo $payslip_dtls->bank_ac_no; ?></td>
                                            <td></td>
                                            <td>Grade</td>
                                            <td class="left_algn">:</td>
                                            <td><?php echo $payslip_dtls->grade; ?></td>

                                        </tr>

                                    </tbody>
                                </table>
                                <br>
                                <table class="width table_2_Uts payslipTable_Uts" cellpadding="6" style="width:100%;">

                                    <thead>
                                        <tr class="t2">
                                            <th colspan="2">Earning</th>
                                            <th colspan="3">Deductions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="left_algn">Basic</td>
                                            <td class="right_algn"><?= $payslip_dtls->basic; ?></td>
                                            <td class="left_algn">Security</td>
                                            <td class="right_algn"></td>
                                            <td class="right_algn"><?= $payslip_dtls->security; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="left_algn">HRA</td>
                                            <td class="right_algn"><?= $payslip_dtls->hra; ?></td>
                                            <td class="left_algn">Insurance</td>
                                            <td class="right_algn"></td>
                                            <td class="right_algn"><?= $payslip_dtls->insurance; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="left_algn">DA</td>
                                            <td class="right_algn"><?= $payslip_dtls->da; ?></td>
                                            <?php if ($payslip_dtls->p_tax > 0) { ?>
                                                <td class="left_algn">Prof. Tax</td>
                                                <td></td>
                                                <td class="right_algn"><?= $payslip_dtls->p_tax; ?></td>
                                            <?php } else { ?>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            <?php } ?>
                                        </tr>
                                        <tr>
                                            <td class="left_algn">Conveyance</td>
                                            <td class="right_algn"><?= $payslip_dtls->ta; ?></td>
                                            <?php if ($payslip_dtls->income_tax_tds > 0) { ?>
                                                <td class="left_algn">Income Tax TDS</td>
                                                <td></td>
                                                <td class="right_algn"><?= $payslip_dtls->income_tax_tds; ?></td>
                                            <?php } else { ?>
                                                <td class="left_algn"></td>
                                                <td></td>
                                                <td class="right_algn"></td>
                                            <?php } ?>
                                        </tr>
                                        <tr>
                                            <td class="left_algn">Medical Allowance</td>
                                            <td class="right_algn"><?= $payslip_dtls->ma; ?></td>
                                            <?php if ($payslip_dtls->loan_prin > 0) { ?>
                                                <td class="left_algn">Loan</td>
                                                <td>Prin.</td>
                                                <td class="right_algn"><?= $payslip_dtls->loan_prin; ?></td>
                                            <?php } else { ?>
                                                <td class="left_algn"></td>
                                                <td></td>
                                                <td class="right_algn"></td>
                                            <?php } ?>
                                        </tr>
                                        <!-- <tr>
                                            <td class="left_algn"></td>
                                            <td class="right_algn"></td>
                                            <td class="left_algn">G.I.C.I.</td>
                                            <td></td>
                                            <td class="right_algn"><?= $payslip_dtls->gici; ?></td>
                                        </tr> -->
                                        <?php if ($payslip_dtls->loan_int > 0) { ?>
                                            <tr>
                                                <td class="left_algn"></td>
                                                <td class="right_algn"></td>
                                                <td class="left_algn"></td>
                                                <td>Int.</td>
                                                <td class="right_algn"><?= $payslip_dtls->loan_int; ?></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td class="left_algn"></td>
                                            <td class="right_algn"></td>
                                            <td class="left_algn">Other Deduction</td>
                                            <td></td>
                                            <td class="right_algn"><?= $payslip_dtls->other_did; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="left_algn"></td>
                                            <td class="right_algn"></td>
                                            <td class="left_algn">Total Deduction</td>
                                            <td></td>
                                            <td class="right_algn"><?= $payslip_dtls->tot_diduction; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="left_algn"><b>Gross Amount Payable</b></td>
                                            <td class="right_algn"><?= $payslip_dtls->final_gross; ?></td>
                                            <td class="left_algn" colspan="2"><b>Net Amount Payable</b></td>
                                            <td class="right_algn"><?= $payslip_dtls->net_sal; ?></td>
                                        </tr>

                                    </tbody>


                                </table>
                                <div>
                                    <p style="display: inline;">Amount (<small>in words</small>):
                                        <b> <?php echo getIndianCurrency($payslip_dtls->net_sal); ?>
                                    </p></b>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type='button' id='btn' value='Print' onclick='printDiv();'>
            </div>

        </div>


    <?php
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    ?>
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="card">
                    <div class="card-body">
                        <h3>Payslip Report</h3>
                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="POST" id="form" action="<?php echo site_url("reports/payslipreport"); ?>">
                                            <div class="form-group">
                                                <div class="row">

                                                    <div class="col-4">
                                                        <label for="exampleInputName1">Month:</label>
                                                        <select class="form-control required" name="sal_month" id="sal_month" required>
                                                            <option value="">Select Month</option>
                                                            <?php foreach ($month_list as $m_list) { ?>
                                                                <option value="<?php echo $m_list->id ?>"><?php echo $m_list->month_name; ?></option>

                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleInputName1">Input Year:</label>
                                                        <input type="text" class="form-control" name="year" id="year" value="<?php echo date('Y'); ?>" />
                                                    </div>
                                                    <div class="col-4">
                                                        ` <label for="exampleInputName1">Emplyee Name:</label>
                                                        <select class="form-control required" name="emp_cd" id="emp_cd" required>
                                                            <option value="">Select Employee</option>
                                                            <?php

                                                            if ($emp_list) {
                                                                foreach ($emp_list as $e_list) {
                                                            ?>
                                                                    <option value='<?php echo $e_list->emp_code ?>'>
                                                                        <?php echo $e_list->emp_name; ?></option>
                                                            <?php
                                                                }
                                                            }    ?>
                                                        </select>
                                                    </div>`
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