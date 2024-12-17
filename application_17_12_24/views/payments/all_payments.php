<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2><strong>Dashboard -> User Payments </strong></h2>
        </div>
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>Payments List</strong>
                        </h2>
                        <hr>
                        <div style="overflow-x:scroll;">
                            <form method="get">
                                <div class="row clearfix">
                                    <div class="col-md-4">
                                        <b>Payment For</b>
                                        <div class="form-group">
                                            <select id="type" class="form-control" name="type">
                                                <option value="">Select Payment For</option>
                                                <option value="0" <?php if (isset($_GET['type']) && $_GET['type'] == "0") echo "selected"; ?>>Membership</option>
                                                <option value="1" <?php if (isset($_GET['type']) && $_GET['type'] == "1") echo "selected"; ?>>Course</option>
                                                <option value="2" <?php if (isset($_GET['type']) && $_GET['type'] == "2") echo "selected"; ?>>Test Series</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" name="submit" value="submit" id="submit" class="btn btn-link waves-effect">Search</button>
                                        <?php if(isset($_GET['type']) || isset($_GET['user_id'])){ ?>
                                            <a href="<?=base_url();?><?php echo $this->uri->segment(1); ?>" class="btn btn-link waves-effect">Reset</a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </form>                                
                        </div>
                        <hr>
                        <div style="overflow-x:scroll;">
                            <table id="user_question_data" class="table table-bordered table-striped table-hover dataTable js-exportable nowrap" width="100%">
                                <thead>
                                    <tr>
                                        <th width="10%">Sr. No.</th>
                                        <th>User Details</th>
                                        <th>Payment Status</th>
                                        <th>Payment Amount</th>
                                        <th>Transaction ID</th>
                                        <th>Payment On</th>
                                        <th>Payment For</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th width="10%">Sr. No.</th>
                                        <th>User Details</th>
                                        <th>Payment Status</th>
                                        <th>Payment Amount</th>
                                        <th>Transaction ID</th>
                                        <th>Payment On</th>
                                        <th>Payment For</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>