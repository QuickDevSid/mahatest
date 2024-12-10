<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> Test Series - Manage Test Series List</h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>Manage Test Series List</strong>
                        </h2>
                        <hr>
                        <table id="test_series_data_list" class="table table-striped list_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Title</th>
                                    <th>Sub Title</th>
                                    <th>Sale Price</th>
                                    <th>MRP</th>
                                    <th>Discount</th>
                                    <!-- <th>Description</th> -->
                                    <th>Image Uploaded</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($category)) :
                                    // print_r($category);
                                    // exit;
                                ?>
                                    <?php $i = 1; ?>
                                    <?php foreach ($category as $cat) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= htmlspecialchars($cat->title); ?></td>
                                            <td><?= htmlspecialchars($cat->sub_headings); ?></td>
                                            <td><?= htmlspecialchars($cat->sale_price); ?></td>
                                            <td><?= htmlspecialchars($cat->mrp); ?></td>
                                            <td><?= htmlspecialchars($cat->discount); ?></td>
                                            <!-- <td><?= htmlspecialchars($cat->description); ?></td> -->
                                            <td>
                                                <?php if ($cat->banner_image != '') { ?>
                                                    <img src="<?= base_url() ?>assets/uploads/test_series/images/<?= $cat->banner_image ?>" alt="Image" style="width: 100px; height: auto;" />
                                                <?php } else { ?>
                                                    No Image
                                                <?php } ?>
                                            </td>
                                            <td><?= htmlspecialchars($cat->record_status); ?></td>

                                            <td>
                                                <?php if ($cat->record_status == 'Active'): ?>
                                                    <a href="<?= base_url('test_series/status_test_series_list_active/' . $cat->id); ?>" class="btn btn-primary btn-sm">In-Active</a>
                                                <?php else: ?>
                                                    <a href="<?= base_url('test_series/status_test_series_list_in_active/' . $cat->id); ?>" class="btn btn-primary btn-sm">Active</a>
                                                <?php endif; ?>

                                                <a href="<?= base_url('test_series/add_test_series/' . $cat->id); ?>" class="btn btn-primary btn-sm">Edit</a>
                                                <a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?');" href="<?= base_url('test_series/delete_test_series_list/' . $cat->id); ?>">
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
        $('#test_series_data_list').DataTable({
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