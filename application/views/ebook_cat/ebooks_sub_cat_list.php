<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD -> Ebook - Ebook Sub Category List</h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>Sub Category List</strong>
                        </h2>
                        <hr>
                        <!-- <form action="" method="get">
                            <div class="row">
                                <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                    <label>Title Name<b class="require">*</b></label>
                                    <input type="text" class="form-control" name="title" id="title" value="<?= !empty($single) ? $single->title : '' ?>" placeholder="Enter Title Name">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                    <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                                    <a class="btn btn-primary row-btns" href="<?= base_url(); ?><?= $this->uri->segment(1); ?>">Reset</a>
                                </div>
                            </div>
                        </form> -->
                        <table id="ebooks_sub_cat" class="table table-striped list_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Title</th>
                                    <th>Category Name</th>
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
                                            <td><?= htmlspecialchars($cat->sub_category_title); ?></td>
                                            <td><?= htmlspecialchars($cat->category_title); ?></td>
                                            <td>
                                                <?php if ($cat->sub_category_icon != '') { ?>
                                                    <img src="<?= base_url() ?>assets/ebook_images/<?= $cat->sub_category_icon ?>" alt="Image" style="width: 100px; height: auto;" />
                                                <?php } else { ?>
                                                    No Image
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('ebook_cat/ebooks_sub_cat/' . $cat->id); ?>" class="btn btn-primary btn-sm">Edit</a>
                                                <a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?');" href="<?= base_url('ebook_cat/delete_ebooks_sub_cat/' . $cat->id); ?>">
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
        $('#ebooks_sub_cat').DataTable({
            dom: 'Blfrtip',
            responsive: false,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [{
                extend: 'excel',
                footer: true,
                filename: 'Ebook Sub Category list',
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