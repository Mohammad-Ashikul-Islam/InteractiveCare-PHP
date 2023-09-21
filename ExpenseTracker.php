<?php


$Category = ["Family", "Personal", "Institutional", "Passive", "Gift"];

class ExpenseTracker
{
    // Add Income Processing Method
    public function AddIncome() : void
    {
        echo "\nEnter the amount: ";
        (int) $amount = (int) readline();
        (int) $categoryIndex = ProcessCategory();
        if ($categoryIndex == -1) {
            echo "Invalid category !\n";
            return;
        }
        global $Category;
        (string) $selectedCategory = $Category[$categoryIndex];
        $file = fopen("Incomes.txt", "a+");
        fwrite($file, ($selectedCategory." ".$amount."\n"));
        fclose($file);
        echo "Income added successfully !\n";
    }

    // Add Expense Processing Method
    public function AddExpense() : void
    {
        echo "\nEnter the amount: ";
        (int) $amount = (int)readline();
        (int) $categoryIndex = ProcessCategory();
        if ($categoryIndex == -1) {
            echo "Invalid category !\n";
            return;
        }
        global $Category;
        (string) $selectedCategory = $Category[$categoryIndex];
        $file = fopen("Expenses.txt", "a+");
        fwrite($file, ($selectedCategory." ".$amount."\n"));
        fclose($file);
        echo "Expense added successfully !\n";
    }

    // ViewIncomes Processing Method
    public function ViewIncomes() : void {
        $file = fopen("Incomes.txt","r");
        (int) $counter = 0;
        echo "\nAll income records\n";
        while( ($income = fgets($file)) !== false ){
            echo "--> ".$income;
            $counter++;
        }
        if($counter==0) echo "You do not have any income record !\n";
        fclose($file);
    }

    // ViewExpenses Processing Method
    public function ViewExpenses() : void {
        $file = fopen("Expenses.txt","r");
        (int) $counter = 0;
        echo "\nAll expense records\n";
        while( ($expense = fgets($file)) !== false ){
            echo "--> ".$expense;
            $counter++;
        }
        if($counter==0) echo "You do not have any expense record !\n";
        fclose($file);
    }

    // ViewSavings Processing Method
    public function ViewSavings() : void {
        (int) $savings = 0;
        echo "\nYour savings is: ";
        $file = fopen("Incomes.txt","r");
        while( ($income = fgets($file)) !== false ){
            $savings += (int) (explode(" ",$income)[1]);
        }
        fclose($file);
        $file = fopen("Expenses.txt","r");
        while( ($expense = fgets($file)) !== false ){
            $savings -= (int) (explode(" ",$expense)[1]);
        }
        fclose($file);
        echo $savings." !\n";
    }

    // ViewCategory Processing Method
    public function ViewCategories() : Void {
        global $Category;
        echo "\nCategories are: \n";
        foreach ($Category as $category) echo "--> $category\n";
    }

}

function ProcessCategory() : int
{
    echo "Enter the category: ";
    (string) $inputtedCategory = readline();
    $inputtedCategory = strtolower($inputtedCategory);
    global $Category;
    for ((int)$i = 0; $i < count($Category); $i++) {
        if (strtolower($Category[$i]) == $inputtedCategory) return $i;
    }
    return -1;
}

function PrintOptions(): void
{
    echo "\n1. Add Income\n";
    echo "2. Add Expense\n";
    echo "3. View Incomes\n";
    echo "4. View Expenses\n";
    echo "5. View Savings\n";
    echo "6. View Categories\n";
    echo "0. Exit\n";
}

// Driver code starts from here
$selfExpenseTracker = new ExpenseTracker();
while(true) {
    try {
        PrintOptions();
        echo "\nSelect an option: ";
        (int) $selectedOption = (int) readline();
        if ($selectedOption == 0) break;
        else if ($selectedOption == 1) $selfExpenseTracker->AddIncome();
        else if ($selectedOption == 2) $selfExpenseTracker->AddExpense();
        else if ($selectedOption == 3) $selfExpenseTracker->ViewIncomes();
        else if ($selectedOption == 4) $selfExpenseTracker->ViewExpenses();
        else if ($selectedOption == 5) $selfExpenseTracker->ViewSavings();
        else if ($selectedOption == 6) $selfExpenseTracker->ViewCategories();
    } catch (Exception $e){
        echo "An exception occurred: " . $e->getMessage();
    }
}