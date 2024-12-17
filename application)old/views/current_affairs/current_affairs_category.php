<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> Current Affairs -> Category  </h2>
        </div>
        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Category
                            <a href="<?=base_url();?>add_current_affairs_category_form" class="btn bg-teal waves-effect pull-right">
                                 <i class="material-icons">person_add</i>
                                 <span>Add Category</span>
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
                                    <th>Category Name</th>
                                    <th width="10%">Action</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th width="10%">Sr. No.</th>
                                    <th>Category Name</th>
                                    <th width="10%">Action</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                        $i=1;
                                        if(!empty($category)){
                                            foreach($category as $row){
                                    ?>
                                                <tr>
                                                    <td><?=$i++;?></td>
                                                    <td><?= $row->category_name;?></td>
                                                    <td>
                                                        <?php if($row->category_name == 'All'){ ?>
                                                            -
                                                        <?php }else{ ?>
                                                        <a href="<?=base_url();?>add_current_affairs_category_form/<?=$row->id;?>" class="btn bg-teal waves-effect">
                                                            <i class="material-icons">edit</i>
                                                        </a>
                                                        <a href="<?=base_url();?>delete_current_affairs_category/<?=$row->id;?>" class="btn bg-red waves-effect">
                                                            <i class="material-icons">delete</i>
                                                        </a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }else{
                                            ?>
                                            <tr>
                                                <td colspan="3" align="center">No Record Found</td>
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