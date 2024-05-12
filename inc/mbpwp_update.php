<?php
add_action('admin_post_edit_expense_category', 'edit_expense_category');
function edit_expense_category()
{
    global $wpdb;
    $name = $_POST['name'];
    $id = $_POST['id'];
    $expense_category = $wpdb->prefix . "expense_category";
    $wpdb->update($expense_category, ['name' => $name], ['id' => $id]);
    wp_redirect(admin_url('admin.php?page=mbpwp-expense-category'));
    exit;
}




//Edit expense Budget
add_action('admin_post_edit_expense_budget', 'edit_expense_budget');
function edit_expense_budget()
{
    global $wpdb;
    $category_id = $_POST['category_id'];
    $expense_amount = $_POST['expense_amount'];
    $month_id = $_POST['month_id'];
    $id = $_POST['id'];
    echo $id;
    $expense_budget = $wpdb->prefix . "expense_budget";
    $wpdb->update($expense_budget, 
    array(
        "category_id" => $category_id,
        "amount" => $expense_amount,
        "month_id" => $month_id
    ), 
    ["id" => $id]);
    wp_redirect(admin_url('admin.php?page=mbpwp-expense-budget'));
    exit;

}



//Edit expense 
add_action('admin_post_edit_expense', 'edit_expense');
function edit_expense()
{
    global $wpdb;
    $category_id = $_POST['category_id'];
    $month_id = $_POST['month_id'];
    $expense_amount = $_POST['expense_amount'];
    $expense_date = $_POST['expense_date'];
    $id = $_POST['id'];
    echo $id;
    $expense = $wpdb->prefix . "expense";
    $wpdb->update($expense, 
    array(
        "category_id" => $category_id,
        "date" => $expense_date,
        "amount" => $expense_amount,
        "month_id" => $month_id
    ), 
    ["id" => $id]);
    wp_redirect(admin_url('admin.php?page=mbpwp-expense'));
    exit;

}






