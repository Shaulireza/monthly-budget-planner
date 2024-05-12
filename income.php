<?php
global $wpdb;
$months_table = $wpdb->prefix . "months";
$month_data = $wpdb->get_results("select * from $months_table");
$income=$wpdb->prefix."income";
$income_category = $wpdb->prefix . "income_category";
$income_cat_data = $wpdb->get_results("select * from $income_category");
$income_join_result = $wpdb->get_results("SELECT wp_income.*,wp_income_category.name as category,wp_months.name as month FROM wp_income JOIN wp_income_category ON wp_income_category.id=wp_income.category_id JOIN wp_months ON wp_months.id=wp_income.month_id");

// print_r($expense_join_result);

if (isset($_POST['submit'])) {
    $income_category_id = $_POST['income_category_id'];
    $month_id = $_POST['month_id'];
    $income_amount = $_POST['income_amount'];
    $income_date = $_POST['income_date'];
    $wpdb->insert($income, ['category_id' => $income_category_id, 'date' => $income_date , 'amount' => $income_amount, 'month_id' => $month_id,]);
    // wp_redirect(admin_url('admin.php?page=mbpwp-expense'));
    ?>
    <script>
        window.location.assign('<?php echo esc_url('admin.php?page=mbpwp-income') ?>')
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
                        <h3>Add Income</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row">
                                <div class="">
                                    <div class="form-group">
                                        <label for="add_expense_category" class="form-label">Income
                                            Category:</label>
                                        <select name="income_category_id" class="form-select form-select-lg mb-3"
                                            aria-label="Large select example">
                                            <option selected>Select One</option>
                                            <?php
                                            foreach ($income_cat_data as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value->id ?>">
                                                    <?php echo $value->name ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="add_expense_category" class="form-label">Income Month:</label>
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
                                        <label for="add_expense_category" class="form-label">Income
                                            Amount:</label>
                                        <input type="text" name="income_amount" class="form-control mb-3"
                                            id="add_expense_category" aria-describedby="emailHelp">
                                    </div>
                                    <div class="form-group">
                                        <label for="add_expense_category" class="form-label">Income Date</label>
                                        <input type="date" name="income_date" class="form-control mb-3"
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
                        <h3>Income List</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">SL</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Month</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Date</th>
                                    <th style="width: 20%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($income_join_result as $i => $d) { ?>
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
                                            <?php echo $d->date ?>
                                        </td>

                                        <td>
                                            <a
                                                href="<?php //echo esc_url(admin_url('admin.php?page=expense-category-edit&id=' . $d->id)); ?>"><i
                                                    class="far fa-edit me-2"></i>
                                            </a>

                                            <a
                                                href="<?php //echo esc_url(admin_url('admin.php?page=expense-category-delete&id=' . $d->id)); ?>"><i
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
