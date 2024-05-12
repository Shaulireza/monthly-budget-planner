<?php
global $wpdb;
$months_table = $wpdb->prefix . "months";
$expense = $wpdb->prefix . "expense";
$expense_category = $wpdb->prefix . "expense_category";
$exp_cat_data = $wpdb->get_results("select * from $expense_category");
$month_data = $wpdb->get_results("select * from $months_table");
$expense_join_result = $wpdb->get_row("SELECT wp_expense.*,wp_expense_category.name as category,wp_months.name as month FROM wp_expense JOIN wp_expense_category ON wp_expense_category.id=wp_expense.category_id JOIN wp_months ON wp_months.id=wp_expense.month_id where wp_expense.id=" . $_GET['id']);

// echo "<pre>";
// print_r($expense_join_result);

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
        <div class="row justify-content-center">
            <div class="col-md-8  ">
                <div class="card">
                    <div class="card-header bg-warning">
                        <h3>Add Expenses</h3>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                            <div class="row">
                                <div class="">
                                    <div class="form-group">
                                        <label for="add_expense_category" class="form-label">Expense
                                            Category:</label>

                                        <input type="hidden" name="id" value="<?php echo $expense_join_result->id ?>">
                                        <input type="hidden" name="action" value="edit_expense">

                                        <select name="category_id" class="form-select form-select-lg mb-3"
                                            aria-label="Large select example">
                                            <option value="<?php echo $expense_join_result->category_id ?>">
                                                <?php echo $expense_join_result->category ?>
                                            </option>
                                            <?php
                                            foreach ($exp_cat_data as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value->id ?>">
                                                    <?php echo $value->name ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="add_expense_category" class="form-label">Expense Month:</label>
                                        <select name="month_id" class="form-select form-select-lg mb-3"
                                            aria-label="Large select example">
                                            <!-- <option selected>Select Month</option> -->
                                            <option value="<?php echo $expense_join_result->month_id ?>">
                                                <?php echo $expense_join_result->month ?>
                                            </option>
                                            <?php
                                            foreach ($month_data as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value->id ?>">
                                                    <?php echo $value->name ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="add_expense_category" class="form-label">Expense
                                            Amount:</label>
                                        <input type="text" name="expense_amount" class="form-control mb-3"
                                            value="<?php echo $expense_join_result->amount ?>"
                                            id="add_expense_category" aria-describedby="emailHelp">
                                    </div>
                                    <div class="form-group">
                                        <label for="add_expense_category" class="form-label">Expense Date</label>
                                        <input type="date" name="expense_date" class="form-control mb-3"
                                            value="<?php echo $expense_join_result->date ?>" id="add_expense_category"
                                            aria-describedby="emailHelp">
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

        </div>
    </section>
</body>

</html>