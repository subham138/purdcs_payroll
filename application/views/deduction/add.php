<style>
    .table td .form-group {
        width: 165px;
    }
</style>

<div class="main-panel">
    <div class="content-wrapper content_wrapper_custom">
        <div class="card">
            <div class="card-body">
                <h3>Add Deductions</h3>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" id="form" action="<?php echo site_url("slrydedad"); ?>?catg_id=<?= $selected['catg_id'] ?>&sys_dt=<?= $selected['sal_date'] ?>&flag=<?= $selected['sal_flag'] ?>">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-5">
                                                <label for="exampleInputName1">Date:</label>
                                                <input type="date" name="sal_date" class="form-control required" id="sal_date" value="<?= $selected['sal_date']; ?>" />
                                            </div>
                                            <div class="col-5">
                                                <label for="exampleInputName1">Category:</label>
                                                <select class="form-control required" name="catg_id" id="catg_id">
                                                    <option value="">Select Category</option>
                                                    <?php
                                                    if ($catg_list) {
                                                        $select = '';
                                                        foreach ($catg_list as $catg) {
                                                            if ($selected['catg_id'] == $catg->id) {
                                                                $select = 'selected';
                                                            } else {
                                                                $select = '';
                                                            } ?>
                                                            <option value="<?= $catg->id ?>" <?= $select ?>><?= $catg->category; ?></option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </div>
                                            <div class="col-2 float-right">
                                                <label for="exampleInputName1">&nbsp;</label>
                                                <button type="submit" id="submit" name="submit" class="btn btn-warning text-white mr-2 form-control" <?= $is_active ?>>Populate</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php if (isset($_REQUEST['submit'])) {
            $display = '';
            $disabled = '';
            // if ($selected['catg_id'] == 2) {
            //     $display = 'style="display:none;"';
            // } 
        ?>
            <div class="card mt-4">
                <div class="card-body">
                    <h3>Add Deductions</h3>
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body card_bodyCustom">
                                    <form method="POST" id="form" action="<?php echo site_url("slrydedsv"); ?>">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive" id='permanent'>

                                                    <table class="table">
                                                        <thead class="fixedHeaderTable">
                                                            <tr>
                                                                <th>Employee</th>
                                                                <th>GROSS SALARY</th>
                                                                <th>Service P.F.</th>
                                                                <th <?= $display ?>>Loan EMI</th>
                                                                <th <?= $display ?>>Installment No.</th>
                                                                <th>P.Tax</th>
                                                                <!-- <th <?= $display ?>>G.I.C.I</th> -->
                                                                <th <?= $display ?>>Income Tax TDS.</th>
                                                                <th <?= $display ?>>Security</th>
                                                                <th <?= $display ?>>Insurance</th>
                                                                <th <?= $display ?>>Other</th>
                                                                <th>Total Deduction</th>
                                                                <th>NET SALARY</th>
                                                            </tr>

                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $tot_pf = 0;
                                                            $loan_prin = 0;
                                                            $loan_int = 0;
                                                            $tot_p_tax = 0;
                                                            // $tot_gici = 0;
                                                            $tot_income_tax_tds = 0;
                                                            $tot_security = 0;
                                                            $tot_insurance = 0;
                                                            $tot_other = 0;
                                                            $tot_tot_diduction = 0;
                                                            $tot_net_sal = 0;
                                                            if ($sal_list) {
                                                                $i = 0;
                                                                foreach ($sal_list as $sal) {
                                                                    if ($sal['gross'] > 0) {
                                                                        $tot_pf += $sal['pf'];
                                                                        $loan_prin += $sal['loan_emi'];
                                                                        $loan_int += $sal['instal_no'];
                                                                        $tot_p_tax += $sal['p_tax'];
                                                                        // $tot_gici += $sal['gici'];
                                                                        $tot_income_tax_tds += $sal['income_tax_tds'];
                                                                        $tot_security += $sal['security'];
                                                                        $tot_insurance += $sal['insurance'];
                                                                        $tot_other += $sal['other_did'];
                                                                        $tot_tot_diduction += $sal['tot_diduction'];
                                                                        $tot_net_sal += $sal['net_sal'];
                                                                    }
                                                                    if ($sal['gross'] == 'Fill Income First') {
                                                                        $disabled = 'disabled';
                                                                    } ?>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="emp_name[]" id="emp_name_<?= $i ?>" value="<?= $sal['emp_name']; ?>" />
                                                                                <input type="hidden" name="emp_code[]" id="emp_code_<?= $i ?>" value="<?= $sal['emp_code'] ?>">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="gross[]" id="gross_<?= $i ?>" value="<?= $sal['gross']; ?>" onchange="cal_deduction(<?= $i ?>)" readonly />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="pf[]" id="pf_<?= $i ?>" value="<?= $sal['pf']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td <?= $display ?>>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="loan_prin[]" id="loan_prin_<?= $i ?>" value="<?= $sal['loan_emi']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td <?= $display ?>>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="loan_int[]" id="loan_int_<?= $i ?>" value="<?= $sal['instal_no']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="p_tax[]" id="p_tax_<?= $i ?>" value="<?= $sal['p_tax']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <!-- <td <?= $display ?>>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="gici[]" id="gici_<?= $i ?>" value="<?= $sal['gici']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td> -->
                                                                        <td <?= $display ?>>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="income_tax_tds[]" id="income_tax_tds_<?= $i ?>" value="<?= $sal['income_tax_tds']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td <?= $display ?>>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="security[]" id="security_<?= $i ?>" value="<?= $sal['security']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td <?= $display ?>>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="insurance[]" id="insurance_<?= $i ?>" value="<?= $sal['insurance']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td <?= $display ?>>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="other_did[]" id="other_did_<?= $i ?>" value="<?= $sal['other_did']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="tot_diduction[]" id="tot_diduction_<?= $i ?>" value="<?= $sal['tot_diduction']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="net_sal[]" id="net_sal_<?= $i ?>" value="<?= $sal['net_sal']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>

                                                                    </tr>
                                                            <?php $i++;
                                                                }
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td colspan="2">TOTAL: </td>
                                                                <td><span id="tot_pf"><?= $tot_pf ?></span></td>
                                                                <td <?= $display ?>><span id="loan_prin"><?= $loan_prin ?></span></td>
                                                                <td></td>
                                                                <!-- <td <?= $display ?>><span id="loan_int"><?= $loan_int ?></span></td> -->
                                                                <td><span id="tot_p_tax"><?= $tot_p_tax ?></span></td>
                                                                <td <?= $display ?>><span id="tot_income_tax_tds"><?= $tot_income_tax_tds ?></span></td>
                                                                <td <?= $display ?>><span id="tot_security"><?= $tot_security ?></span></td>
                                                                <td <?= $display ?>><span id="tot_insurance"><?= $tot_insurance ?></span></td>
                                                                <td <?= $display ?>><span id="tot_other"><?= $tot_other ?></span></td>
                                                                <td><span id="tot_tot_diduction"><?= $tot_tot_diduction ?></span></td>
                                                                <td style="display: none;"><span id="tot_net_sal"><?= $tot_net_sal ?></span></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <label class="mt-3"><b>Total Net Salary: </b>&#8377 <span id="dis_tot_net_sal"><?= $tot_net_sal ?></span>/-</label>
                                            </div>
                                        </div>
                                        <input type="hidden" name="sal_date" value="<?= $selected['sal_date']; ?>">
                                        <input type="hidden" name="catg_id" value="<?= $selected['catg_id']; ?>">
                                        <input type="hidden" name="flag" value="<?= $selected['sal_flag']; ?>">
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-warning text-white mr-2" <?= $disabled ?> <?= $is_active ?>>Submit</button>
                                            <a href="<?= site_url() ?>/slryded" class="btn btn-light">Back</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        <?php } ?>
    </div>

    <script>
        $('#sal_date').on('change', function() {
            var sal_date = $(this).val()
            var catg_id = $('#catg_id').val()
            if (catg_id > 0) {
                $.ajax({
                    type: "GET",
                    url: "<?= site_url() ?>/salary/chk_deduction",
                    data: {
                        "sal_date": sal_date,
                        "catg_id": catg_id
                    },
                    dataType: 'html',
                    success: function(result) {
                        if (result) {
                            alert("You have already entered this month's deduction");
                            $('#submit').attr('disabled', 'disabled')
                        } else {
                            $('#submit').removeAttr('disabled')
                        }
                    }
                });
            }
        })
        $('#catg_id').on('change', function() {
            var catg_id = $(this).val()
            var sal_date = $('#sal_date').val()
            $.ajax({
                type: "GET",
                url: "<?= site_url() ?>/salary/chk_deduction",
                data: {
                    "sal_date": sal_date,
                    "catg_id": catg_id
                },
                dataType: 'html',
                success: function(result) {
                    if (result) {
                        alert("You have already entered this month's deduction");
                        $('#submit').attr('disabled', 'disabled')
                    } else {
                        $('#submit').removeAttr('disabled')
                    }
                }
            });
        })
    </script>

    <script>
        function cal_deduction(id) {
            var gross = $('#gross_' + id).val();
            var pf = $('#pf_' + id).val();
            var loan_prin = $('#loan_prin_' + id).val();
            // var loan_int = $('#loan_int_' + id).val();
            var loan_int = 0;
            var p_tax = $('#p_tax_' + id).val();
            // var gici = $('#gici_' + id).val();
            var income_tax_tds = $('#income_tax_tds_' + id).val();
            var security = $('#security_' + id).val();
            var insurance = $('#insurance_' + id).val();
            var other = $('#other_did_' + id).val();

            var tot_diduction = $('#tot_diduction_' + id).val();
            var net_sal = $('#net_sal_' + id).val();
            var total_did = parseInt(pf) + parseInt(loan_prin) + parseInt(loan_int) + parseInt(p_tax) + parseInt(income_tax_tds) + parseInt(security) + parseInt(insurance) + parseInt(other)

            $('#tot_diduction_' + id).val(total_did)

            var diduction = parseInt(gross) - parseInt(total_did)
            $('#net_sal_' + id).val(diduction);
            cal_tot_amt();
        }

        function cal_tot_amt() {
            var tot_pf = 0;
            var tot_loan_prin = 0;
            var tot_loan_int = 0;
            var tot_p_tax = 0;
            // var tot_gici = 0;
            var tot_income_tax_tds = 0;
            var tot_security = 0;
            var tot_insurance = 0;
            var tot_other = 0;
            var tot_tot_diduction = 0;
            var tot_net_sal = 0;

            $('input[name="pf[]"]').each(function() {
                tot_pf = parseInt(tot_pf) + parseInt(this.value)
            });
            $('input[name="loan_prin[]"]').each(function() {
                tot_loan_prin = parseInt(tot_loan_prin) + parseInt(this.value)
            });
            // $('input[name="loan_int[]"]').each(function() {
            //     tot_loan_int = parseInt(tot_loan_int) + parseInt(this.value)
            // });
            $('input[name="p_tax[]"]').each(function() {
                tot_p_tax = parseInt(tot_p_tax) + parseInt(this.value)
            });
            // $('input[name="gici[]"]').each(function() {
            //     tot_gici = parseInt(tot_gici) + parseInt(this.value)
            // });
            $('input[name="income_tax_tds[]"]').each(function() {
                tot_income_tax_tds = parseInt(tot_income_tax_tds) + parseInt(this.value)
            });
            $('input[name="security[]"]').each(function() {
                tot_security = parseInt(tot_security) + parseInt(this.value)
            });
            $('input[name="insurance[]"]').each(function() {
                tot_insurance = parseInt(tot_insurance) + parseInt(this.value)
            });

            $('input[name="other_did[]"]').each(function() {
                tot_other = parseInt(tot_other) + parseInt(this.value)
            });

            $('input[name="tot_diduction[]"]').each(function() {
                tot_tot_diduction = parseInt(tot_tot_diduction) + parseInt(this.value)
            });
            $('input[name="net_sal[]"]').each(function() {
                tot_net_sal = parseInt(tot_net_sal) + parseInt(this.value)
            });
            $('#tot_pf').text(tot_pf);
            $('#tot_loan_prin').text(tot_loan_prin);
            $('#tot_loan_int').text(tot_loan_int);
            $('#tot_p_tax').text(tot_p_tax);
            // $('#tot_gici').text(tot_gici);
            $('#tot_income_tax_tds').text(tot_income_tax_tds);
            $('#tot_security').text(tot_security);
            $('#tot_insurance').text(tot_insurance);
            $('#tot_other').text(tot_other);
            $('#tot_tot_diduction').text(tot_tot_diduction);
            $('#tot_net_sal').text(tot_net_sal);
            $('#dis_tot_net_sal').text(tot_net_sal);
        }
    </script>

    <script>
        $(document).ready(function() {
            var catg_id = <?= $selected['catg_id'] ?> > 0 ? <?= $selected['catg_id'] ?> : 0;
            if (catg_id > 0) {
                $('#sal_date').attr('readonly', 'readonly')
                <?php if (!isset($_REQUEST['submit'])) { ?>
                    $('#submit').click();
                <?php } ?>
            }
        })
    </script>