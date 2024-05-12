<?php
/**
 * Plugin Name:       Monthly Budget Planner
 * Plugin URI:        https://wordpress.org/plugins/simple-scroll-to-top-wp/
 * Description:       Money Manager is an easy-to-use multi-currency finance software. It helps organize personal or small business finances and keeps track of where, when and how the money goes.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            ANAM
 * Author URI:        
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://github.com/shovoalways
 * Text Domain:       mbpwp
 */


//Add Theme Styles
function mbpwp_enqueue_style()
{
    //add bootstrap
    wp_enqueue_style("mbpwp_bootstrap", plugin_dir_url(__FILE__) . "css/mbpwp_bootstrap.min.css");
    wp_enqueue_style("mbpwp_style", plugin_dir_url(__FILE__) . "css/mbpwp_style.css");
    wp_enqueue_style("mbpwp_font_awesome", plugin_dir_url(__FILE__) . "css/font_all.min.css");
    wp_enqueue_style('google-font3', "https://fonts.googleapis.com/css2?family=Roboto&display=swap");


    //add Javascript
    wp_enqueue_script("mbpwp_bootstrap_js", plugin_dir_url(__FILE__) . "js/mbpwp_bootstrap.min.js");
    wp_enqueue_script("mbpwp_jquery_js", plugin_dir_url(__FILE__) . "js/mbpwp_jquery-3.7.1.min.js");
    wp_enqueue_script("mbpwp_font_awesome", "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css");
    wp_enqueue_script('jquery');


}
add_action("wp_enqueue_scripts", "mbpwp_enqueue_style");




//Plugin Option Page Function
function mbpwp_add_theme_page()
{
    add_menu_page(
        'Monthly Budget Planner',
        'Budget Planner',
        'manage_options',
        'mbpwp-budget-planner',
        'mbpwp_create_page',
        'dashicons-calendar-alt',
        101,
    );

    //add sub menu expense category
    add_submenu_page(
        'mbpwp-budget-planner',
        'Expense Category',
        'Expense Category',
        'manage_options',
        'mbpwp-expense-category',
        'mbpwp_add_expense_category',

    );

    //add sub menu expense
    add_submenu_page(
        'mbpwp-budget-planner',
        'Expense',
        'Expense',
        'manage_options',
        'mbpwp-expense',
        'mbpwp_add_expense',

    );

    //add sub menu budget expense
    add_submenu_page(
        'mbpwp-budget-planner',
        'Expense Budget',
        'Expense Budget',
        'manage_options',
        'mbpwp-expense-budget',
        'mbpwp_add_expense_budget',

    );

    //add sub menu month
    add_submenu_page(
        'mbpwp-budget-planner',
        'Month',
        'Month',
        'manage_options',
        'mbpwp-month',
        'mbpwp_add_month',

    );


    //expense cat edit
    add_submenu_page(
        null,
        'My Custom Page',
        'My Custom Page',
        'manage_options',
        'expense-category-edit',
        'mbpwp_expense_category_edit',
    );


    //expense Actual edit
    add_submenu_page(
        null,
        'My Custom Page',
        'My Custom Page',
        'manage_options',
        'expense-edit',
        'mbpwp_expense_edit',
    );


    //expense Budget edit
    add_submenu_page(
        null,
        'My Custom Page',
        'My Custom Page',
        'manage_options',
        'expense-budget-edit',
        'mbpwp_expense_budget_edit',
    );

    //jksfkjgndfkjngkjdsfngkjngkjdfngkjdfngkjdfngkjdfngkjd

//add sub menu expense category
add_submenu_page(
    'mbpwp-budget-planner',
    'Income Category',
    'Income Category',
    'manage_options',
    'mbpwp-income-category',
    // 'mbpwp_add_income_category',
    function () {
        include dirname(__FILE__) . '/income_category.php';
    }
    
);

//add sub menu income
add_submenu_page(
    'mbpwp-budget-planner',
    'Income',
    'Income',
    'manage_options',
    'mbpwp-income',
    // 'mbpwp_add_income',
    function () {
        include dirname(__FILE__) . '/income.php';
    }
    
);

//add sub menu budget expense
add_submenu_page(
    'mbpwp-budget-planner',
    'Income Budget',
    'Income Budget',
    'manage_options',
    'mbpwp-income-budget',
    // 'mbpwp_add_income_budget',
    function () {
        include dirname(__FILE__) . '/income_budget.php';
    }
    
);

//income edit
add_submenu_page(
    null,
    'My Custom Page',
    'My Custom Page',
    'manage_options',
    'income-category-edit',
    // 'mbpwp_income_category_edit',
    function () {
        include dirname(__FILE__) . '/income_cate_edit.php';
    }
);


    //jigjghjiosjgdfklgdflgdfgdfngdgdgkjdfgfgkfkjlglklkkkl




}
add_action("admin_menu", "mbpwp_add_theme_page");

function mbpwp_create_page()
{
    include dirname(__FILE__) . '/dashboard.php';
}

//add expense category
function mbpwp_add_expense_category()
{
    include dirname(__FILE__) . '/expense_category.php';
}

//add expense
function mbpwp_add_expense()
{
    include dirname(__FILE__) . '/expense.php';
}

//add expense

function mbpwp_add_expense_budget()
{
    include dirname(__FILE__) . '/expense_budget.php';
}

//expense category edit
function mbpwp_expense_category_edit()
{
    include dirname(__FILE__) . '/expense_cat_edit.php';
}

//expense Actual edit
function mbpwp_expense_edit()
{
    include dirname(__FILE__) . '/expense_edit.php';
}
//expense Actual edit
function mbpwp_expense_budget_edit()
{
    include dirname(__FILE__) . '/expense_budget_edit.php';
}
function mbpwp_add_month()
{
    include dirname(__FILE__) . '/month.php';
}





//Plugin Activation Hook
register_activation_hook(
    __FILE__,
    'mbpwp_create_table'
);
function mbpwp_create_table()
{



    global $wpdb;
    $expense_category = $wpdb->prefix . "expense_category";
    $create_expense_cat = "CREATE TABLE $expense_category(id int AUTO_INCREMENT PRIMARY KEY,name varchar(255))";
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($create_expense_cat);
    $input_cat = ['Food', 'Gift', 'Health/Medical', 'Home', 'Transportation', 'Personal', 'Pets', 'Utilities', 'Travel', 'Debt', 'Other'];

    foreach ($input_cat as $cat) {
        $wpdb->insert($expense_category, ['name' => $cat]);
    }


    //create expense table
    $expense = $wpdb->prefix . "expense";
    $create_expense = "CREATE TABLE $expense(id int AUTO_INCREMENT PRIMARY KEY,category_id int,date date,amount decimal(10,2),month_id int)";
    dbDelta($create_expense);


    //create expense_budget
    $expense_budget = $wpdb->prefix . "expense_budget";
    $create_expense_budget = "CREATE TABLE $expense_budget(id int AUTO_INCREMENT PRIMARY KEY,category_id int,amount decimal(10,2),month_id int)";
    dbDelta($create_expense_budget);


    //create month table
    $months_table = $wpdb->prefix . "months";
    $create_months = "CREATE TABLE $months_table(id int AUTO_INCREMENT PRIMARY KEY,name varchar(50),year varchar(50))";
    dbDelta($create_months);
    $wpdb->insert($months_table, ['name' => "January",'year' => 2024],);





    // kghjkgfhngjfghgdfsjkfcbgjk

     // income table
     $income=$wpdb->prefix."income";
     $queryincome="CREATE TABLE $income(id int AUTO_INCREMENT PRIMARY KEY,category_id int Not Null,date date Not null,amount decimal(10,2) Not Null,month_id int Not Null)";
     dbDelta($queryincome);
 
     // income category table
     $incomecate=$wpdb->prefix ."income_category";
     $querycate="CREATE TABLE $incomecate(id int AUTO_INCREMENT PRIMARY KEY,name varchar(255))";
     dbDelta($querycate);
     $income_cat = ['Savings', 'Paycheck', 'Bonus', 'Interest', 'Other', 'Personal', 'Custom category'];

    foreach ($income_cat as $category) {
        $wpdb->insert($incomecate, ['name' => $category]);
    }
 
     //income budget table
     $incomebudget=$wpdb->prefix."income_budget";
     $querybudget="CREATE TABLE   $incomebudget(id int AUTO_INCREMENT PRIMARY KEY,category_id int Not Null,amount decimal(10,2) Not Null,month_id int Not Null)";
     dbDelta($querybudget);


}




register_deactivation_hook(
    __FILE__,
    'mbpwp_delete_table'
);

function mbpwp_delete_table()
{
    global $wpdb;
    $expense_category = $wpdb->prefix . "expense_category";
    $del_expense_category = "drop table $expense_category";
    $wpdb->query($del_expense_category);

    //delete expense table
    $expense = $wpdb->prefix . "expense";
    $del_expense = "drop table $expense";
    $wpdb->query($del_expense);

    //delete expense budget
    $expense_budget = $wpdb->prefix . "expense_budget";
    $del_expense_budget = "drop table $expense_budget";
    $wpdb->query($del_expense_budget);

    //delete months table
    $months = $wpdb->prefix . "months";
    $del_months = "drop table $months";
    $wpdb->query($del_months);




    // lgjjglfgjghlfgjhkigjhfgjhoi
    $income=$wpdb->prefix."income";
    $queryincome = "drop table $income";
    $wpdb->query($queryincome);

    //delete income category table
    $incomecate=$wpdb->prefix ."income_category";
    $querycate = "drop table $incomecate";
    $wpdb->query($querycate);

    //delete income budget table
    $incomebudget=$wpdb->prefix."income_budget";
    $querybudget = "drop table $incomebudget";
    $wpdb->query($querybudget );
}








//all update function here
include_once("inc/mbpwp_update.php");


//jfgjdfgjdfgijdfngjdfngkjdfngkjdfngjdfngdfjgkjdf

add_action("admin_menu", "mbpwp_add_theme_page");

//income category edit function
add_action('admin_post_update_income_category', 'edit_income_cate');
function edit_income_cate()
{
    global $wpdb;
    $name = $_POST['add_income_category'];
  
    $id = $_POST['id'];
    $incomecate= $wpdb->prefix . "income_category";
    $wpdb->update($incomecate,['name'=>$name],['id'=>$id]);
    wp_redirect(admin_url('admin.php?page=mbpwp-income-category'));
    exit;
}

?>