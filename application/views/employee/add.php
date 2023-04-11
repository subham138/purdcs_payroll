<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h3>Employee Add</h3>
                <?php if ($this->session->flashdata('msg')) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $this->session->flashdata('msg'); ?>
                    </div>
                <?php } ?>

                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" id="form" action="<?php echo site_url("emadst"); ?>">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputName1">Employee Code:<span class="requiredfield">*</span></label>
                                                <input type="text" name="emp_code" class="form-control" id="emp_code" value="" required />
                                            </div>
                                            <div class="col-6">
                                                <label for="exampleInputName1">Employee Name:<span class="requiredfield">*</span></label>
                                                <input type="text" name="emp_name" class="form-control" id="emp_name" value="" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputName1">Category:<span class="requiredfield">*</span></label>
                                                <select class="form-control" name="emp_catg" id="emp_catg" required />
                                                <option value="">Select Category</option>
                                                <?php foreach ($category_dtls as $c_list) {
                                                ?>
                                                    <option value="<?php echo $c_list->id ?>">
                                                        <?php echo $c_list->category; ?>
                                                    </option>
                                                <?php
                                                }
                                                ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputName1">Date of Birth:<span class="requiredfield">*</span></label>
                                                <input type="date" class="form-control" name="dob" id="dob" required value="" />
                                            </div>
                                            <div class="col-6">
                                                <label for="exampleInputName1">Joining Date:<span class="requiredfield">*</span></label>
                                                <input type="date" class="form-control" name="join_dt" id="join_dt" required value="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputName1">Retirement Date:</label>
                                                <input type="date" class="form-control" name="ret_dt" id="ret_dt" value="" />
                                            </div>
                                            <div class="col-6">
                                                <label for="exampleInputName1">Email:</label>
                                                <input type="email" class="form-control" name="email" id="email" value="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputName1">Phone No.<span class="requiredfield">*</span></label>
                                                <input type="text" class="form-control" name="phn_no" required id="phn_no" value="" />
                                            </div>
                                            <div class="col-6">
                                                <label for="exampleInputName1">Designation:</label>
                                                <select class="form-control" name="designation" id="designation">
                                                    <option value="">Select Department</option>
                                                    <?php foreach ($desig as $de) { ?>
                                                        <option value="<?php echo $de->id ?>">
                                                            <?php echo $de->name; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputName1">Department:</label>
                                                <input type="text" class="form-control required" name="department" id="department" value="" />
                                            </div>
                                            <div class="col-6">
                                                <label for="exampleInputName1">Grade:</label>
                                                <input type="text" class="form-control required" name="grade" id="grade" value="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputName1">Address:</label>
                                                <textarea type="text" class="form-control required" name="emp_addr" id="emp_addr"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-header">

                                        <h4>Basic Pay</h4>

                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputName1">Basic Pay:<span class="requiredfield">*</span></label>
                                                <input type="text" class="form-control required" name="basic_pay" required id="basic_pay" value="" />
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-header">
                                        <h4>Bank & Other Details</h4>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputName1">Bank Name:</label>
                                                <input type="text" class="form-control" name="bank_name" id="bank_name" value="" />
                                            </div>
                                            <div class="col-6">
                                                <label for="exampleInputName1">A/C No.:</label>
                                                <input type="text" class="form-control" name="bank_ac_no" id="bank_ac_no" value="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputName1">IFSC Code:</label>
                                                <input type="text" class="form-control" name="bank_ifsc" id="bank_ifsc" value="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputName1">PF A/C No.:</label>
                                                <input type="text" class="form-control" name="pf_ac_no" id="pf_ac_no" value="" />
                                            </div>
                                            <div class="col-6">
                                                <label for="exampleInputName1">UAN.:</label>
                                                <input type="text" class="form-control" name="uan" id="uan" value="" />
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputName1">Pan No.:</label>
                                                <input type="text" class="form-control" name="pan_no" id="pan_no" value="" />
                                            </div>
                                            <div class="col-6">
                                                <label for="exampleInputName1">Aadhar No.:</label>
                                                <input type="text" class="form-control required" name="aadhar" id="aadhar" value="" />
                                            </div>

                                        </div>
                                    </div>
                                    <input type="hidden" name="emp_dist" value="339">
                                    <button type="submit" class="btn btn-warning text-white mr-2">Submit</button>
                                    <button type="button" class="btn btn-light" onclick="window.location.href='<?= site_url() ?>/stfemp'">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        $('#dob').change(function() {

            var now = new Date($('#dob').val());
            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);
            var year = now.getFullYear() + 60;
            var rtday = year + "-" + (month) + "-" + (day);
            $('#ret_dt').val(rtday);

        })
    </script>