<?php
global $wpdb;
$months_table = $wpdb->prefix . "months";
$expense_budget = $wpdb->prefix . "expense_budget";
$expense_category = $wpdb->prefix . "expense_category";
$exp_cat_data = $wpdb->get_results("select * from $expense_category");
$month_data = $wpdb->get_results("select * from $months_table");
$exp_budget_result = $wpdb->get_results("SELECT wp_expense_budget.*,wp_expense_category.name as category,wp_months.name as month FROM wp_expense_budget JOIN wp_expense_category ON wp_expense_category.id=wp_expense_budget.category_id JOIN wp_months ON wp_months.id=wp_expense_budget.month_id");



if (isset($_POST['submit'])) {
    $category_id = $_POST['category_id'];
    $expense_amount = $_POST['expense_amount'];
    $month_id = $_POST['month_id'];
    // $wpdb->insert($expense_budget, ['category_id' => $category_id, 'expense_bud_amount' => $expense_amount, 'month_id' => $month_id,]);
    $wpdb->insert($expense_budget, array(
        'category_id' => $category_id,
        'amount' => $expense_amount,
        'month_id' => $month_id
    ));
    ?>
    <script>
        window.location.assign('<?php echo esc_url('admin.php?page=mbpwp-expense-budget') ?>')
    </script>
    <?php
}

if (isset($_GET['type']) && $_GET['type'] == 'delete') {
    $wpdb->delete($expense_budget, ['id' => $_GET['id']]);
    ?>
    <script>
        window.location.assign('<?php echo esc_url('admin.php?page=mbpwp-expense-budget') ?>')
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
                    <div class="card-header bg-warning">
                        <h3>Add Expenses Budget</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row">
                                <div class="">
                                    <div class="form-group">
                                        <label for="add_expense_category" class="form-label">Expense
                                            Category:</label>
                                        <select name="category_id" class="form-select form-select-lg mb-3"
                                            aria-label="Large select example">
                                            <option selected>Select One</option>
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
                                            <option selected>Select Month</option>
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
                                            id="add_expense_category" aria-describedby="emailHelp">
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
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header bg-success">
                        <h3>Expense Budget List</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">SL</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Month</th>
                                    <th scope="col">Amount</th>
                                    <th style="width: 10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($exp_budget_result as $i => $d) { ?>
                                    <tr>
                                        <th scope="row">
                                            <?php echo $i + 1 ?>
                                        </th>
                                        <td>
                                            <?php echo $d->category ?>
                                        </td>
                                        <td>
                                            <?php echo $d->month ?>
                                        </td>
                                        <td>
                                            <?php echo $d->amount ?>
                                        </td>

                                        <td>
                                            <a
                                                href="<?php echo esc_url(admin_url('admin.php?page=expense-budget-edit&id=' . $d->id)); ?>"><i
                                                    class="far fa-edit me-2"></i>
                                            </a>

                                            <a
                                                href="<?php echo esc_url(admin_url('admin.php?page=mbpwp-expense-budget&type=delete&id=' . $d->id)); ?>"><i
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