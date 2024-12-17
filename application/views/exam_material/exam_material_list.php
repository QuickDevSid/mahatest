<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> Exam Material - Exam Material List</h2>
        </div>
        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>Exam Material List</strong>
                        </h2>
                        <hr>
                        <table id="course_data_list" class="table table-striped list_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Title</th>
                                    <th>Image Uploaded</th>
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
                                            <td>
                                                <?php if ($cat->icon != '') { ?>
                                                    <img src="<?= base_url() ?>assets/uploads/exam_material/images/<?= $cat->icon ?>" alt="Image" style="width: 100px; height: auto;" />
                                                <?php } else { ?>
                                                    No Image
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($cat->id == '9') { ?>
                                                    <a href="<?= base_url('exam_material/add_examwise_pdf/' . $cat->id); ?>" class="btn btn-danger btn-sm" style="margin: 5px;">Examwise Pdf</a>
                                                    <a href="<?= base_url('exam_material/examwise_pdf_list'); ?>" class="btn btn-primary btn-sm" style="margin: 5px;">Examwise Pdf List</a>
                                                <?php } elseif ($cat->id == '8') { ?>
                                                    <a href="<?= base_url('exam_material/add_subjectwise_test/' . $cat->id); ?>" class="btn btn-danger btn-sm" style="margin: 5px;">Subjectwise Test</a>
                                                    <a href="<?= base_url('exam_material/subjectwise_test_list'); ?>" class="btn btn-primary btn-sm" style="margin: 5px;">Subjectwise Test List</a>
                                                    <a href="<?= base_url('exam_material/add_examwise_test/' . $cat->id); ?>" class="btn btn-danger btn-sm" style="margin: 5px;">Examwise Test</a>
                                                    <a href="<?= base_url('exam_material/examwise_test_list'); ?>" class="btn btn-primary btn-sm" style="margin: 5px;">Examwise Test List</a>
                                                <?php } else { ?>
                                                    <a href="<?= base_url('exam_material/add_subjectwise_pdf/' . $cat->id); ?>" class="btn btn-primary btn-sm" style="margin: 5px;">Subjectwise Pdf</a>
                                                    <a href="<?= base_url('exam_material/subjectwise_pdf_list'); ?>" class="btn btn-primary btn-sm" style="margin: 5px;">Subjectwise Pdf List</a>
                                                    <a href="<?= base_url('exam_material/add_subjectwise_test/' . $cat->id); ?>" class="btn btn-danger btn-sm" style="margin: 5px;">Subjectwise Test</a>
                                                    <a href="<?= base_url('exam_material/subjectwise_test_list'); ?>" class="btn btn-danger btn-sm" style="margin: 5px;">Subjectwise Test List</a>
                                                    <a href="<?= base_url('exam_material/add_examwise_pdf/' . $cat->id); ?>" class="btn btn-primary btn-sm" style="margin: 5px;">Examwise Pdf</a>
                                                    <a href="<?= base_url('exam_material/examwise_pdf_list'); ?>" class="btn btn-primary btn-sm" style="margin: 5px;">Examwise Pdf List</a>
                                                    <a href="<?= base_url('exam_material/add_examwise_test/' . $cat->id); ?>" class="btn btn-danger btn-sm" style="margin: 5px;">Examwise Test</a>
                                                    <a href="<?= base_url('exam_material/examwise_test_list'); ?>" class="btn btn-danger btn-sm" style="margin: 5px;">Examwise Test List</a>
                                                <?php } ?>
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
        $('#course_data_list').DataTable({
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