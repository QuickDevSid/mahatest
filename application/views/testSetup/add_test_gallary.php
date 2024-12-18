<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2><strong>Dashboard -> Test Setup </strong></h2>
        </div>
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>Upload Test Gallary</strong>
                        </h2>
                        <hr>
                        <form id="test_gallary_submit" enctype="multipart/form-data" action="<?php echo base_url() ?>TestSetup/add_test_gallary" method="POST">
                            <input type="hidden" name="source_type" value="test_setup">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="body">
                                        <div class="demo-masked-input">
                                            <div class="row clearfix">
                                                <div class="col-md-4">
                                                    <b>Images File* <small>(.zip, .jpg, .jpeg, .png allowed)</small></b>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">note</i>
                                                        </span>
                                                        <div class="form-line">
                                                            <input type="file" accept=".zip, .jpg, .jpeg, .png" name="zipfile" id="zipfile" class="form-control file">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="submit" name="gallary_submit" value="gallary_submit" id="gallary_submit" class="btn btn-link waves-effect">SAVE DETAILS</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <table id="test_series_data_list" class="table">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Image</th>
                                    <th>Image Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach($videos as $index => $video) { 
                                    $is_allocated = $this->TestSetup_Model->check_image_is_allocated($video);
                                ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td>
                                        <a target="_blank" href="<?= base_url(); ?>assets/uploads/master_gallary/<?= $video ?>" title="View File">
                                            <img style="width:35px;" src="<?= base_url(); ?>assets/uploads/master_gallary/<?= $video ?>">
                                        </a>
                                    </td>
                                    <td>
                                        <?= $video ?>
                                        <a class="copy-btn" data-clipboard-text="<?= $video ?>" onclick="copyToClipboard('<?= $video ?>')" title="Copy Image Name">
                                            <i class="material-icons" style="margin-left:10px;font-size: 15px !important;cursor:pointer;">content_copy</i>
                                        </a>
                                        <span class="copy-message" id="copy-message-<?= $video ?>" style="display:none; color: green; margin-left: 10px;">Image name copied to clipboard!</span>
                                    </td>
                                    <td>
                                        <?php if($is_allocated == 0){ ?>
                                            <a href="<?= base_url(); ?>delete_image?path=assets/uploads/master_gallary/<?= $video ?>" 
                                                onclick="return confirm('Are you sure to delete this image?');" 
                                                class="btn bg-red waves-effect btn-xs" 
                                                style="text-decoration:none;" 
                                                title="Delete">
                                                <i class="material-icons">delete</i>
                                            </a>
                                        <?php }else{ echo '-'; } ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
function copyToClipboard(fileName) {
    // Create a temporary input to hold the file name
    var tempInput = document.createElement("input");
    tempInput.value = fileName;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand("copy");
    
    // Show success message
    var message = document.getElementById('copy-message-' + fileName);
    message.style.display = 'inline';  // Show the message
    
    // Fade out after 5 seconds
    setTimeout(function() {
        message.style.display = 'none';
    }, 5000);
}
</script>