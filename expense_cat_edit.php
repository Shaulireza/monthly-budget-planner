<?php
global $wpdb;
$expense_category = $wpdb->prefix . "expense_category";
$edit_exp_cat = $wpdb->get_row("select * from $expense_category where id=" . $_GET['id']);

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
    <div class="row justify-content-center">
        <div class="col-sm-6 mb-3 ">
            <div class="card">
                <div class="card-header">
                    <h3>Add Expense Category</h3>
                </div>
                <div class="card-body">
                    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                        <div class="row">
                            <div class="">
                                <div class="form-group">
                                    <label for="add_expense_category" class="form-label">Enter Your Expense
                                        Category:</label>
                                    <input type="hidden" name="id" value="<?php echo $edit_exp_cat->id ?>">
                                    <input type="hidden" name="action" value="edit_expense_category">
                                    <input type="text" name="name" class="form-control"
                                        id="add_expense_category" aria-describedby="emailHelp" value="<?php echo $edit_exp_cat->name ?>" >
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="row">
                            <div class="card-footer">
                                <button type="submit" name="submit" class="btn btn-success btn-block">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>