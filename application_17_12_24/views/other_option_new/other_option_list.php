<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <?php if(isset($_GET['syllabus'])){ ?>
                <h2>DASHBOARD ->Syllabus</h2>
            <?php }else{ ?>
                <h2>DASHBOARD ->Other Options - Other Options List</h2>
            <?php } ?>
        </div>
        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <?php if(isset($_GET['syllabus'])){ ?>
                                <strong>Syllabus List</strong>
                            <?php }else{ ?>
                                <strong>Other Options List</strong>
                            <?php } ?>
                        </h2>
                        <hr>
                        <table id="other_option_data_list" class="table table-striped list_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Title</th>
                                    <th>Can Download</th>
                                    <th>Image Uploaded</th>
                                    <th>PDF Uploaded</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($category)) : ?>
                                    <?php $i = 1; ?>
                                    <?php foreach ($category as $cat) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= htmlspecialchars($cat->title); ?></td>
                                            <td><?= htmlspecialchars($cat->can_download); ?></td>
                                            <td>
                                                <?php if ($cat->image_url != '') { ?>
                                                    <img src="<?= base_url() ?>assets/uploads/other_options/images/<?= $cat->image_url ?>" alt="Image" style="width: 100px; height: auto;" />
                                                <?php } else { ?>
                                                    No Image
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($cat->pdf_url != '') { ?>
                                                    <a href="<?= base_url() ?>assets/uploads/other_options/pdfs/<?= $cat->pdf_url ?>" target="_blank">
                                                        View PDF
                                                    </a>
                                                <?php } else { ?>
                                                    No PDF Available
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if($cat->other_option_category_id == '4'){ ?>
                                                    <a href="<?= base_url('other_option_new/add_other_option/' . $cat->id . '?syllabus'); ?>" class="btn btn-primary btn-sm">Edit</a>
                                                <?php }else{ ?>
                                                    <a href="<?= base_url('other_option_new/add_other_option/' . $cat->id); ?>" class="btn btn-primary btn-sm">Edit</a>
                                                <?php } ?>    
                                                <a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?');" href="<?= base_url('other_option_new/delete_other_option_list/' . $cat->id); ?>">
                                                    Delete
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="10" class="text-center">No results found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<!-- DataTables JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $(document).ready(function() {
        $('#other_option_data_list').DataTable({
            dom: 'Blfrtip',
            responsive: false,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [{
                extend: 'excel',
                footer: true,
                filename: 'Courses list',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            }],
        });
    });
    flatpickr(".date_time", {
        // enableTime: true,
        dateFormat: "d-m-Y",
    });
    document.addEventListener("DOMContentLoaded", function() {
        flatpickr("#date_time", {
            mode: "range",
            dateFormat: "d-m-Y",
            onClose: function(selectedDates, dateStr, instance) {}
        });
    });
</script>