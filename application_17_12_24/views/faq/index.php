<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> FAQ</h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                        FAQ
                          <button type="button" class="btn bg-teal waves-effect pull-right" data-toggle="modal"
                                     data-target="#addFAQ">
                                 <i class="material-icons">person_add</i>
                                 <span>Add FAQ</span>
                             </button>
                        </h2>

                    </div>
                    <div class="body">
                        <div class="table-responsive js-sweetalert">
                            <table id="user_data"
                                   class="table table-bordered table-striped table-hover dataTable js-exportable nowrap" width="100%">
                                <thead>
                                <tr>
                                    <th width="10%">Action</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th width="10%">Added On</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Action</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Added On</th>
                                </tr>
                                </tfoot>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Task Info -->

        </div>
    </div>
</section>

<!-- Modal Start here -->

<div class="modal fade" id="addFAQ" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <form class="form-horizontal" id="submit">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add FAQ Detail </h4>
                </div>
                <div class="modal-body">
                    <!-- Masked Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">

                                <div class="body">
                                    <div class="demo-masked-input">
                                    <div class="row clearfix">
                                        <div class="col-md-6">
                                                <b>Title</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="title" id="title"
                                                               class="form-control text" placeholder="Title" required>
                                                    </div>
                                                </div>
                                            </div>


                                           <div class="col-md-6">
                                              <p>
                                                  <b>Description</b>
                                              </p>
                                              <textarea name="description" id="description"
                                                               class="form-control text"></textarea>

                                          </div>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Masked Input -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-link waves-effect">SAVE DETAILS
                    </button>
                    <button type="button" class="btn btn-link waves-effect"
                            data-dismiss="modal">CLOSE
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>




<div class="modal fade" id="showFAQ" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document" id="getFAQDetails">
        <form class="form-horizontal" id="">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">FAQ Details</h4>
                </div>
                <div class="modal-body">
                    <!-- Masked Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="body">
                                    <div class="demo-masked-input">
                                        <div class="row clearfix">                                            
                                            <div class="col-md-4">
                                                <b>Title</b>
                                                <div class="input-group">
                                                   <span class="input-group-addon">
                                                       <i class="material-icons">security</i>
                                                   </span>
                                                    <div class="form-line">
                                                        <input type="text" name="s_title" id="s_title" class="form-control text" placeholder="Title" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Description</b>
                                                <div class="input-group">
                                                   <span class="input-group-addon">
                                                       <i class="material-icons">security</i>
                                                   </span>
                                                    <div class="form-line">
                                                        <textarea name="s_description" id="s_description" class="form-control text"  disabled></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <b>Created On</b>
                                                <div class="input-group">
                                                   <span class="input-group-addon">
                                                       <i class="material-icons">security</i>
                                                   </span>
                                                    <div class="form-line">
                                                        <input type="text" name="s_created_at" id="s_created_at" class="form-control text" placeholder="CreatedOn" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- assets/images/> -->
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Masked Input -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="editFAQ" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document" id="getbannerDetails">
        <form class="form-horizontal" id="submit_faq">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit FAQ Details </h4>
                </div>
                <div class="modal-body">
                    <!-- Masked Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <input type="hidden" name="e_id" id="e_id" class="form-control text" placeholder="Post ID">
                                <div class="body">
                                    <div class="demo-masked-input">
                                        
                                        <div class="row clearfix">
                                            <div class="col-md-6">
                                                    <b>Title</b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">person</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <input type="text" name="title" id="e_title"
                                                                class="form-control text" placeholder="Title" required>
                                                        </div>
                                                    </div>
                                                </div>


                                            <div class="col-md-6">
                                                <p>
                                                    <b>Description</b>
                                                </p>
                                                <textarea name="description" id="e_description"
                                                                class="form-control text"></textarea>

                                            </div>
 
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Masked Input -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-link waves-effect">UPDATE DETAILS
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>




