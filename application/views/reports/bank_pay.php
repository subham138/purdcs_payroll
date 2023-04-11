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
                            <h4>Salary account for the month of <?php echo MONTHS[$this->input->post('sal_month')] . '-' . $this->input->post('year'); ?></h4>
                            <!-- <h4><?php echo $payslip_dtls->emp_name; ?></h4> -->

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sl No.</th>
                                            <th>Emp Code</th>
                                            <th>Name</th>
                                            <th>Bank Name</th>
                                            <th>Bank Account</th>
                                            <th>IFSC Code</th>
                                            <th>Salary</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($payslip_dtls) {
                                            $i  =   1;
                                            $tot_sal = 0;
                                            foreach ($payslip_dtls as $dt) {
                                                $tot_sal += $dt->net_sal;
                                        ?>
                                                <tr>
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $dt->emp_code; ?></td>
                                                    <td><?= $dt->emp_name; ?></td>
                                                    <td><?= $dt->bank_name; ?></td>
                                                    <td><?= $dt->bank_ac_no; ?></td>
                                                    <td><?= $dt->bank_ifsc; ?></td>
                                                    <td><?= $dt->net_sal; ?></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                            <tr>
                                                <td colspan="2">Total Amount</td>
                                                <td colspan="5"><?= $tot_sal; ?></td>
                                            </tr>
                                        <?php
                                        } else {
                                            echo "<tr><td colspan='7' style='text-align:center;'>No Data Found</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
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
                        <h3>Bank Slip Report</h3>
                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="POST" id="form" action="<?php echo site_url("reports/bank_pay_slip"); ?>">
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