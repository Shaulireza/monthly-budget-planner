<?php
global $wpdb;
$expense = $wpdb->prefix . "expense";
$expense_budget = $wpdb->prefix . "expense_budget";
$expense_category = $wpdb->prefix . "expense_category";

$incomecate = $wpdb->prefix . "income_category";
$income = $wpdb->prefix . "income";
$incomebudget = $wpdb->prefix . "income_budget";

$current_month = date('F');
$current_year = date('Y');

//month table
$month = $wpdb->get_row("select * from wp_months where name='$current_month' and year='$current_year'");

//expense total
$expense_budget_total = $wpdb->get_row("SELECT SUM(amount) as expense_budget_total FROM wp_expense_budget WHERE wp_expense_budget.month_id ='$month->id'");
$expense_total = $wpdb->get_row("SELECT SUM(amount) as expense_total FROM wp_expense wp_expense WHERE wp_expense.month_id ='$month->id'");

//income total 
$income_budget_total = $wpdb->get_row("SELECT SUM(amount) as income_budget_total FROM wp_income_budget WHERE wp_income_budget.month_id ='$month->id'");
$income_total = $wpdb->get_row("SELECT SUM(amount) as income_total FROM wp_income WHERE wp_income.month_id ='$month->id'");



//expense dashboard data
$exp_cat_data = $wpdb->get_results("SELECT wp_expense_budget.amount as expense_bud_amount,wp_expense_category.name,wp_expense_category.id as category_id FROM wp_expense_category  JOIN wp_expense_budget ON wp_expense_budget.category_id=wp_expense_category.id  WHERE wp_expense_budget.month_id ='$month->id'");

$exp_data_graph = $wpdb->get_results("SELECT wp_expense_category.name as country, wp_expense_budget.amount as value FROM wp_expense_category  JOIN wp_expense_budget ON wp_expense_budget.category_id=wp_expense_category.id  WHERE wp_expense_budget.month_id ='$month->id'");

//income dashboard data
$inc_cat_data = $wpdb->get_results("SELECT wp_income_budget.amount as income_bud_amount,wp_income_category.name,wp_income_category.id as category_id FROM wp_income_category JOIN wp_income_budget ON wp_income_budget.category_id=wp_income_category.id WHERE wp_income_budget.month_id ='$month->id'");
// echo '<pre>';
// print_r($inc_cat_data);

//expense data delete
if (isset($_GET['type']) && $_GET['type'] == 'delete') {
    $wpdb->delete($expense_category, ['id' => $_GET['id']]);
    $wpdb->delete($expense, ['category_id' => $_GET['id']]);
    $wpdb->delete($expense_budget, ['category_id' => $_GET['id']]);
    ?>
    <script>
        window.location.assign('<?php echo esc_url('admin.php?page=mbpwp-budget-planner') ?>')
    </script>
    <?php
}

//income data delete
if (isset($_GET['typeincome']) && $_GET['typeincome'] == 'deleteincome') {
    $wpdb->delete($incomecate, ['id' => $_GET['id']]);
    $wpdb->delete($income, ['category_id' => $_GET['id']]);
    $wpdb->delete($incomebudget, ['category_id' => $_GET['id']]);
    ?>
    <script>
        window.location.assign('<?php echo esc_url('admin.php?page=mbpwp-budget-planner') ?>')
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
    <div class="container">
        <div class="row">
            <div class="col-md-6 py-5">

                <div>
                    <h5>Planed / Actual Expense</h5>
                    <?php include_once('inc/expense_chart.php') ?>
                </div>

                <div>
                    <h5>Actual Expense</h5>
                    <?php include_once('inc/expense_bar_chart.php') ?>
                </div>
            </div>
            <div class="col-md-6 py-5">
                <div>
                    <h5>Planed / Actual Income</h5>
                    <?php include_once('inc/income_pie_chart.php') ?>
                </div>

                <div>
                    <h5>Actual Income</h5>
                    <?php include_once('inc/income_bar_chart.php') ?>
                </div>

            </div>
        </div>
    </div>


    <div class="container">
        <div class="row">
            <!-- Expenses -->
            <div class="col-md-6">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width:40%">Your Expense</th>
                            <th style="width:20%">Planned</th>
                            <th style="width:20%">Actual</th>
                            <th style="width:20%">Different</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($exp_cat_data as $i => $d) {
                            $data = $wpdb->get_row("SELECT sum(amount) as amount from wp_expense WHERE wp_expense.category_id=$d->category_id and month_id=$month->id");

                            ?>
                            <tr data-id="1" data-type="income" id="each_row">
                                <td>
                                    <?php echo $d->name ?>
                                </td>
                                <td class="table-secondary text-center">
                                    <?php echo $d->expense_bud_amount ?>
                                </td>
                                <td class="table-success text-center">
                                    <?php echo $data->amount ?>
                                </td>

                                <td class="table-danger text-center">
                                    <?php echo $d->expense_bud_amount - $data->amount ?>
                                </td>
                                <td>

                                    <a
                                        href="<?php echo esc_url(admin_url('admin.php?page=mbpwp-budget-planner&type=delete&id=' . $d->category_id)); ?>"><i
                                            class="fas fa-trash ms-3" style="color: #FF0000;"></i>
                                    </a>
                                </td>
                            </tr>

                        <?php } ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <td style="width:40%">Total :</td>
                            <td style="width:20%" class="text-end">
                                <span class="input-group-text text-end">$
                                    <?php echo (int) $expense_budget_total->expense_budget_total ?>
                                </span>
                            </td>
                            <td style="width:20%">
                                <span class="input-group-text">$
                                    <?php echo (int) $expense_total->expense_total; ?>
                                </span>
                            </td>
                            <td style="width:20%">
                                <span class="input-group-text">$
                                    <?php echo $expense_budget_total->expense_budget_total - $expense_total->expense_total; ?>
                                </span>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- <button class="btn btn-success" id="anam">Add Income Row</button> -->
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal">
                                            Add Expense Row
                                        </button>

                                        <!-- Modal -->
                                        <form action="">
                                            <div class="modal fade" id="exampleModal" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add
                                                                Income
                                                                Row
                                                            </h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <label for="add_income_row" class="form-label">Enter Name
                                                                For
                                                                Income:</label>
                                                            <input type="text" id="add_income_row" class="form-control">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="javascript:void(0)" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</a>
                                                            <button type="button" id="add_category_btn"
                                                                name="add_category" class="btn btn-success">Save
                                                                changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>

                    </tfoot>
                </table>
            </div>

            <!-- Income Area -->
            <div class="col-md-6">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width:40%">Your Income</th>
                            <th style="width:20%">Planned</th>
                            <th style="width:20%">Actual</th>
                            <th style="width:20%">Different</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($inc_cat_data as $i => $d) {
                            $data = $wpdb->get_row("SELECT sum(amount) as amount from wp_income WHERE wp_income.category_id=$d->category_id and month_id=$month->id");

                            ?>
                            <tr data-id="1" data-type="income" id="each_row">
                                <td>
                                    <?php echo $d->name ?>
                                </td>
                                <td class="table-secondary text-center">
                                    <?php echo $d->income_bud_amount ?>
                                </td>
                                <td class="table-success text-center">
                                    <?php echo $data->amount ?>
                                </td>

                                <td class="table-danger text-center">
                                    <?php echo $d->income_bud_amount - $data->amount ?>
                                </td>
                                <td>

                                    <a
                                        href="<?php echo esc_url(admin_url('admin.php?page=mbpwp-budget-planner&typeincome=deleteincome&id=' . $d->category_id)); ?>"><i
                                            class="fas fa-trash ms-3" style="color: #FF0000;"></i>
                                    </a>
                                </td>
                            </tr>

                        <?php } ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <td style="width:40%">Total :</td>
                            <td style="width:20%" class="text-end">
                                <span class="input-group-text text-end">$
                                    <?php echo (int) $income_budget_total->income_budget_total ?>
                                </span>
                            </td>
                            <td style="width:20%">
                                <span class="input-group-text">$
                                    <?php echo (int) $income_total->income_total; ?>
                                </span>
                            </td>
                            <td style="width:20%">
                                <span class="input-group-text">$
                                    <?php echo $income_budget_total->income_budget_total - $income_total->income_total; ?>
                                </span>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- <button class="btn btn-success" id="anam">Add Income Row</button> -->
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal">
                                            Add Income Row
                                        </button>

                                        <!-- Modal -->
                                        <form action="">
                                            <div class="modal fade" id="exampleModal" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add
                                                                Income
                                                                Row
                                                            </h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <label for="add_income_row" class="form-label">Enter Name
                                                                For
                                                                Income:</label>
                                                            <input type="text" id="add_income_row" class="form-control">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="javascript:void(0)" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</a>
                                                            <button type="button" id="add_category_btn"
                                                                name="add_category" class="btn btn-success">Save
                                                                changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>

                    </tfoot>
                </table>
            </div>

        </div>
    </div>

</body>

</html>

<script>
    $(document).ready(function () {
        //Modal Function
        $('#myModal').on('shown.bs.modal', function () {
            $('#myInput').trigger('focus')
        })
        //add new row
        $('#add_category_btn').click(function () {
            let category = $('#add_category').val()
            console.log(category)
        })

    });



</script>