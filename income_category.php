<?php
global $wpdb;
$income_category = $wpdb->prefix . "income_category";
$income_cat_data = $wpdb->get_results("select * from $income_category");
if (isset($_POST['submit'])) {
    $add_income_category = $_POST['add_income_category'];
    $wpdb->insert ($income_category, ['name' => $add_income_category]);

?>
    <script>
        window.location.assign('<?php echo esc_url('admin.php?page=mbpwp-income-category') ?>')
    </script>
    <?php
}

if (isset($_GET['type']) && $_GET['type'] == 'delete') {
    $wpdb->delete($income_category , ['id' => $_GET['id']]);
    ?>
    <script>
        window.location.assign('<?php echo esc_url('admin.php?page=mbpwp-income-category') ?>')
    </script>
    <?php
}


?>

<!DOCTYPE html>
<html lang="<?php language_attributes() ?>">

<head>
    <meta charset="utf-8">
    <title>
        <?php bloginfo() ?>
    </title>
    <?php wp_head() ?>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">


</head>

<body>
    <section>
        <div class="row">
            <div class="col-sm-4 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h3>Add Income Category</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row">
                                <div class="">
                                    <div class="form-group">
                                        <label for="add_income_category" class="form-label">Enter Your Income
                                            Category:</label>
                                        <input type="text" name="add_income_category" class="form-control"
                                            id="add_income_category" aria-describedby="emailHelp">
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="row">
                                <div class="card-footer">
                                    <button type="submit" name="submit"
                                        class="btn btn-success btn-block">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Category List -->
            <div class="col-sm-6 offset-2">
                <div class="card">
                    <div class="card-header">
                        <h3>Category List</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Income Category</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($income_cat_data  as $i => $d) { ?>
                                    <tr>
                                        <th scope="row">
                                            <?php echo $i + 1 ?>
                                        </th>
                                        <td>
                                            <?php echo $d->name ?>
                                        </td>
                                        <td>
                                            <a
                                                href="<?php echo esc_url(admin_url('admin.php?page=income-category-edit&id=' . $d->id)); ?>"><i
                                                    class="far fa-edit me-2"></i>
                                            </a>

                                            <a
                                                href="<?php echo esc_url(admin_url('admin.php?page=mbpwp-income-category&type=delete&id=' . $d->id)); ?>"><i
                                                    class="fas fa-trash" style="color: #FF0000;"></i>
                                            </a>

                                        </td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>