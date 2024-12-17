<section class="content">

    <div class="container-fluid">

        <div class="block-header">

            <h2>DASHBOARD -> Marathi Sabd Sangrah - Category List</h2>

        </div>



        <div class="row clearfix">

            <!-- Task Info -->

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <div class="card">

                    <div class="header">

                        <h2>

                            <strong>Category List</strong>

                        </h2>

                        <hr>

                        <table id="category_list" class="table table-striped list_table" style="width:100%">

                            <thead>

                                <tr>

                                    <th>Sr. No.</th>

                                    <th>Title</th>

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

                                            <td><?= htmlspecialchars($cat->category_name); ?></td>



                                            <td>

                                                <a href="<?= base_url('marathi_sabd/marathi_sabd_category/' . $cat->id); ?>" class="btn btn-primary btn-sm">Edit</a>

                                                <a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?');" href="<?= base_url('marathi_sabd/delete_marathi_sabd_category/' . $cat->id); ?>">

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

        $('#category_list').DataTable({

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