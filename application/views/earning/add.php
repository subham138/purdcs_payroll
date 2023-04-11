<style>
    .table td .form-group {
        width: 165px;
    }
</style>

<div class="main-panel">
    <div class="content-wrapper content_wrapper_custom">
        <div class="card">
            <div class="card-body">
                <h3>Add Earnings</h3>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" id="form" action="<?php echo site_url("slryad"); ?>?catg_id=<?= $selected['catg_id'] ?>&sys_dt=<?= $selected['sal_date'] ?>&flag=<?= $selected['sal_flag'] ?>">
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
            if ($selected['catg_id'] == 2) {
                $display = 'style="display:none;"';
            } ?>
            <div class="card mt-4">
                <div class="card-body">
                    <h3>Add Earnings</h3>
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body card_bodyCustom">
                                    <form method="POST" id="form" action="<?php echo site_url("salsv"); ?>">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive" id='permanent'>

                                                    <table class="table">
                                                        <thead class="fixedHeaderTable">
                                                            <tr>
                                                                <th>Emp name</th>
                                                                <th>Basic</th>
                                                                <th <?= $display ?>>D.A.</th>
                                                                <th <?= $display ?>>H.R.A.</th>
                                                                <th <?= $display ?>>Medical Allowance</th>
                                                                <th <?= $display ?>>Conveyance</th>
                                                                <th>Gross Salary</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $tot_final_gross = 0;
                                                            $tot_basic = 0;
                                                            $tot_da = 0;
                                                            $tot_hra = 0;
                                                            $tot_ma = 0;
                                                            $tot_ta = 0;
                                                            $tot_gross = 0;
                                                            if ($sal_list) {
                                                                $i = 0;
                                                                foreach ($sal_list as $sal) {
                                                                    $tot_basic += $sal['basic'];
                                                                    $tot_da += $sal['da'];
                                                                    $tot_hra += $sal['hra'];
                                                                    $tot_ma += $sal['ma'];
                                                                    $tot_ta += $sal['ta'];
                                                                    $tot_gross += $sal['gross'];
                                                            ?>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="emp_name[]" class="form-control required" id="emp_name_<?= $i ?>" value="<?= $sal['emp_name']; ?>" readonly />
                                                                                <input type="hidden" name="emp_code[]" id="emp_code_<?= $i ?>" value="<?= $sal['emp_code'] ?>">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="basic[]" class="form-control required" id="basic_<?= $i ?>" value="<?= $sal['basic']; ?>" readonly />
                                                                            </div>
                                                                        </td>
                                                                        <td <?= $display ?>>
                                                                            <div class="form-group">
                                                                                <input type="text" name="da[]" class="form-control required" id="da_<?= $i ?>" value="<?= $sal['da']; ?>" readonly />
                                                                            </div>
                                                                        </td>
                                                                        <td <?= $display ?>>
                                                                            <div class="form-group">
                                                                                <input type="text" name="hra[]" class="form-control required" id="hra_<?= $i ?>" value="<?= $sal['hra']; ?>" readonly />
                                                                            </div>
                                                                        </td>
                                                                        <td <?= $display ?>>
                                                                            <div class="form-group">
                                                                                <input type="text" name="ma[]" class="form-control required" id="ma_<?= $i ?>" value="<?= $sal['ma']; ?>" onchange="cash_cal(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td <?= $display ?>>
                                                                            <div class="form-group">
                                                                                <input type="text" name="ta[]" class="form-control required" id="ta_<?= $i ?>" value="<?= $sal['ta']; ?>" onchange="cash_cal(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="gross[]" class="form-control required" id="gross_<?= $i ?>" value="<?= $sal['gross']; ?>" readonly />
                                                                            </div>
                                                                        </td>
                                                                    </tr>

                                                            <?php $i++;
                                                                }
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td>Total:</td>
                                                                <td><span id="tot_basic"><?= $tot_basic ?></span></td>
                                                                <td><span id="tot_da"><?= $tot_da ?></span></td>
                                                                <td <?= $display ?>><span id="tot_hra"><?= $tot_hra ?></span></td>
                                                                <td <?= $display ?>><span id="tot_ma"><?= $tot_ma ?></span></td>
                                                                <td <?= $display ?>><span id="tot_ta"><?= $tot_ta ?></span></td>
                                                                <td><span id="tot_gross"><?= $tot_gross ?></span></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <label class="mt-3"><b>Total Gross Salary (After Deduction): </b>&#8377 <span id="dis_tot_gross"><?= $tot_gross ?></span>/-</label>
                                            </div>
                                        </div>
                                        <input type="hidden" name="sal_date" value="<?= $selected['sal_date']; ?>">
                                        <input type="hidden" name="catg_id" value="<?= $selected['catg_id']; ?>">
                                        <input type="hidden" name="flag" value="<?= $selected['sal_flag']; ?>">
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-warning text-white mr-2" <?= $is_active ?>>Submit</button>
                                            <a href="<?= site_url() ?>/slrydtl" class="btn btn-light">Back</a>
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
                    url: "<?= site_url() ?>/salary/chk_sal",
                    data: {
                        "sal_date": sal_date,
                        "catg_id": catg_id
                    },
                    dataType: 'html',
                    success: function(result) {
                        if (result) {
                            alert("You have already entered this month's earning");
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
                url: "<?= site_url() ?>/salary/chk_sal",
                data: {
                    "sal_date": sal_date,
                    "catg_id": catg_id
                },
                dataType: 'html',
                success: function(result) {
                    if (result) {
                        alert("You have already entered this month's earning");
                        $('#submit').attr('disabled', 'disabled')
                    } else {
                        $('#submit').removeAttr('disabled')
                    }
                }
            });
        })
    </script>

    <script>
        function cash_cal(id) {
            var ma = $('#ma_' + id).val(),
                basic = $('#basic_' + id).val(),
                da = $('#da_' + id).val(),
                hra = $('#hra_' + id).val(),
                gross = $('#gross_' + id).val(),
                ta = $('#ta_' + id).val(),
                tot_gross = 0,
                tot_ma = 0,
                tot_ta = 0;
            $('#gross_' + id).val(parseInt(basic) + parseInt(da) + parseInt(hra) + parseInt(ma) + parseInt(ta));
            $('input[name="ma[]"]').each(function() {
                tot_ma = parseInt(tot_ma) + parseInt(this.value)
            });
            $('input[name="gross[]"]').each(function() {
                tot_gross = parseInt(tot_gross) + parseInt(this.value)
            });
            $('input[name="ta[]"]').each(function() {
                tot_ta = parseInt(tot_ta) + parseInt(this.value)
            });
            $('#tot_gross').text(tot_gross)
            $('#dis_tot_gross').text(tot_gross)
            $('#tot_ma').text(tot_ma)
            $('#tot_ta').text(tot_ta)
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