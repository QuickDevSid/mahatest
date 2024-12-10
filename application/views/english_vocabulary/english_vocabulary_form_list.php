<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> English Vocabulary - English Vocabulary List</h2>
        </div>
        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>English Vocabulary List</strong>
                        </h2>
                        <hr>
                        <table id="current_affair_list" class="table table-striped list_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Sequence No</th>
                                    <!-- <th>Category</th> -->
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($category)) : ?>
                                    <?php $i = 1; ?>
                                    <?php foreach ($category as $cat) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= htmlspecialchars($cat->sequence_no); ?></td>
                                            <!-- <td><?= htmlspecialchars($cat->category); ?></td> -->
                                            <td><?= htmlspecialchars($cat->english_vocabulary_title); ?></td>
                                            <td><?= htmlspecialchars($cat->status); ?></td>
                                            <td>
                                                <?php if (!empty($cat->english_vocabulary_image)) { ?>
                                                    <img src="<?= base_url() ?>assets/uploads/english_vocabulary/images/<?= $cat->english_vocabulary_image ?>" alt="Image" style="width: 100px; height: auto;" />
                                                <?php } else { ?>
                                                    No Image
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($cat->status == 'Active') { ?>
                                                <a href="<?= base_url('english_vocabulary/english_vocabulary_form_inactive/' . $cat->id); ?>" class="btn btn-primary btn-sm">Inactive</a>
                                                <?php } else { ?>
                                                    <a href="<?= base_url('english_vocabulary/english_vocabulary_form_active/' . $cat->id); ?>" class="btn btn-success btn-sm">Active</a>
                                                <?php } ?>

                                                <a href="<?= base_url('english_vocabulary/english_vocabulary_form/' . $cat->id); ?>" class="btn btn-primary btn-sm">Edit</a>
                                                <a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?');" href="<?= base_url('english_vocabulary/delete_english_vocabulary_form/' . $cat->id); ?>">
                                                    Delete
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    
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

<!-- DataTables CSS -->

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">



<!-- DataTables JavaScript -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>





<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>

    $(document).ready(function() {

        $('#current_affair_list').DataTable({

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