<?php
global $wpdb;
$months_table = $wpdb->prefix . "months";

//month submit
if (isset($_POST['submit_month'])) {
    $month = $_POST['month'];
    $year = $_POST['year'];
    $wpdb->insert($months_table, ['name' => $month, 'year' => $year]);

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
            <div class="col-sm-6 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h3>Add Expense Month</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row">
                                <div class="">
                                    <div class="form-group">
                                        <label for="add_expense_category" class="form-label">Month</label>
                                        <input type="text" name="month" class="form-control" id="add_expense_category"
                                            aria-describedby="emailHelp">
                                    </div>
                                    <div class="form-group">
                                        <label for="add_expense_category" class="form-label">Year</label>
                                        <input type="text" name="year" class="form-control" id="add_expense_category"
                                            aria-describedby="emailHelp">
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="row">
                                <div class="card-footer">
                                    <button type="submit" name="submit_month"
                                        class="btn btn-success btn-block">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</head>