<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> Current Affairs -> Tests  </h2>
        </div>
        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Tests
                            <a href="<?=base_url();?>current_affairs/add-test" class="btn bg-teal waves-effect pull-right">
                                 <i class="material-icons">person_add</i>
                                 <span>Add Test</span>
                            </a>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive js-sweetalert">
                            <table id="user_data_course_tests"
                                   class="table table-bordered table-striped table-hover dataTable js-exportable nowrap" width="100%">
                                <thead>
                                <tr>
                                    <th width="10%">Sr. No.</th>
                                    <th width="10%">Action</th>
                                    <th>Category</th>
                                    <th>Tests</th>
                                    <th>Test Details</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th width="10%">Sr. No.</th>
                                    <th width="10%">Action</th>
                                    <th>Category</th>
                                    <th>Tests</th>
                                    <th>Test Details</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                        $i=1;
                                        if(!empty($tests)){
                                            foreach($tests as $row){
                                                $tests_text = $this->CurrentAffairs_model->get_course_test_texts($row->tests);
                                    ?>
                                                <tr>
                                                    <td><?=$i++;?></td>
                                                    <td>
                                                        <a href="<?=base_url();?>current_affairs/add-test/<?=$row->id;?>" class="btn bg-teal waves-effect">
                                                            <i class="material-icons">edit</i>
                                                        </a>
                                                        <a href="<?=base_url();?>current_affairs/delete-test/<?=$row->id;?>" class="btn bg-red waves-effect">
                                                            <i class="material-icons">delete</i>
                                                        </a>
                                                    </td>
                                                    <td><?= $row->category_name;?></td>
                                                    <td><?= $tests_text;?></td>
                                                    <td><a style="text-decoration:underline;" target="_blank" href="<?=base_url();?>test-list?ids=<?=$row->tests;?>">View</a></td>
                                                </tr>
                                                <?php
                                            }
                                        }else{
                                            ?>
                                            <tr>
                                                <td colspan="5" align="center">No Record Found</td>
                                            </tr>
                                            <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>