<?php
namespace App\classes;

class CLIBankingApp{

    private ?User $user = null;
    private array $credentialDatas;
    private array $transactionDatas;

    public function __construct()
    {
        if(file_exists("./Credentials.txt"))
            $this->credentialDatas = unserialize(file_get_contents("./Credentials.txt"));
        else $this->credentialDatas = [];
        if(file_exists("./Transactions.txt"))
            $this->transactionDatas = unserialize(file_get_contents("./Transactions.txt"));
        else $this->transactionDatas = [];
    }

    public function run() : void {
        while(true){
            if($this->user == null){
                $optionManager = new OptionsManager();
                $optionManager->showInitialOptions();
                $selectedOption = intval(readline());
                if($selectedOption <=0 || $selectedOption >=3){
                    echo "\nInvalid Option Selected, Try again !\n";
                }
                else if ($selectedOption == 1)
                    $optionManager->handleLogIn($this->user,$this->credentialDatas);
                else if($selectedOption == 2)
                    $optionManager->handleRegister("Customer", $this->credentialDatas);

                continue;
            }
            else if($this->user->type=="Customer"){
                $optionManager->showCustomerOption();
                $selectedOption = intval(readline());
                if($selectedOption==0){
                    $this->user = null;
                    continue;
                }
                if($selectedOption<0 || $selectedOption>5){
                    echo "\nInvalid option selected !\n";
                    continue;
                }
                if($selectedOption==1){
                    echo "\nYour transactions: \n";
                    foreach ($this->transactionDatas as $transactionData) {
                        $values = explode(" ",$transactionData);
                        if($values[0]==$this->user->email) echo $transactionData."\n";
                    }
                }
                if($selectedOption==2){
                    echo "\nEnter amount: ";
                    $amount = floatval(readline());
                    if($amount<=0.0){
                        echo "\nInvalid amount !\n";
                        continue;
                    }
                    $transactionString = $this->user->email." deposited ".$this->user->email." ".$amount;
                    $this->transactionDatas[] = $transactionString;
                    file_put_contents("./Transactions.txt",serialize($this->transactionDatas));
                    echo "\nDeposited successfully !\n";
                }
                if($selectedOption==3){
                    echo "\nEnter amount: ";
                    $amount = floatval(readline());
                    if($amount<=0.0){
                        echo "\nInvalid amount !\n";
                        continue;
                    }
                    if($amount > $optionManager->calculateBalance($this->user, $this->transactionDatas)){
                        echo "\nAmount is greater than your account balance !\n";
                        continue;
                    }
                    $transactionString = $this->user->email." withdrawn ".$this->user->email." ".$amount;
                    $this->transactionDatas[] = $transactionString;
                    file_put_contents("./Transactions.txt",serialize($this->transactionDatas));
                    echo "\nWithdrawn successfully !\n";
                }
                if($selectedOption==4){
                    echo "\nEnter amount: ";
                    $amount = floatval(readline());
                    if($amount<=0.0){
                        echo "\nInvalid amount !\n";
                        continue;
                    }
                    if($amount > $optionManager->calculateBalance($this->user, $this->transactionDatas)){
                        echo "\nAmount is greater than your account balance !\n";
                        continue;
                    }
                    echo "Enter receiver email: ";
                    $receiverEmail = readline();
                    if(!$optionManager->checkEmailExistence($this->credentialDatas, $receiverEmail)){
                        echo "\nInvalid receiver email !\n";
                        continue;
                    }
                    $transactionString = $this->user->email." sent ".$receiverEmail." ".$amount;
                    $this->transactionDatas[] = $transactionString;
                    $transactionString = $receiverEmail." received ".$this->user->email." ".$amount;
                    $this->transactionDatas[] = $transactionString;
                    file_put_contents("./Transactions.txt",serialize($this->transactionDatas));
                    echo "\nTransferred successfully !\n";
                }
                if($selectedOption==5){
                    $balance = $optionManager->calculateBalance($this->user, $this->transactionDatas);
                    echo "Your account balance is: ".$balance."\n";
                }
            }
            else if($this->user->type=="Admin"){
                $optionManager->showAdminOptions();
                $selectedOption = intval(readline());
                if($selectedOption==0){
                    $user = null;
                    continue;
                }
                if($selectedOption<0 || $selectedOption>3){
                    echo "\nInvalid option selected !\n";
                    continue;
                }
                if($selectedOption==1) {
                    echo "\nAll Transactions: \n";
                    foreach ($this->transactionDatas as $transactionData) echo $transactionData."\n";
                }
                if($selectedOption==2){
                    echo "\nEnter customer email: ";
                    $email = readline();
                    echo "All transactions by ".$email.": \n";
                    foreach ($this->transactionDatas as $transactionData){
                        $values = explode(" ",$transactionData);
                        if($values[0]==$email) echo $transactionData."\n";
                    }
                    echo "\n";
                }
                if($selectedOption == 3){
                    echo "All Customers: \n";
                    foreach ($this->credentialDatas as $credentialData){
                        $values = explode(" ",$credentialData);
                        if($values[2] == "Customer") echo "Email: ".$values[0]." Name: ".$values[3]."\n";
                    }
                    echo "\n";
                }
            }
        }
    }

    public function runAdminRegister() : void {
        while(true){
            $optionManager = new OptionsManager();
            echo "\nOptions: \n";
            echo "1. Register an admin\n";
            echo "0. Exit\n";
            echo "Select an option: ";
            $selectedOption = intval(readline());
            if($selectedOption == 0 ) {
                $this->user = null;
                break;
            }
            else
                $optionManager->handleRegister("Admin", $this->credentialDatas);
        }
    }

}