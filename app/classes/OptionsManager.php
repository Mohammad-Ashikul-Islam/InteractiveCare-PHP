<?php

namespace App\classes;

class OptionsManager{
    public function showInitialOptions() : void{
        echo "\n";
        echo "Options: \n";
        echo "1. Login\n";
        echo "2. Register\n";
        echo "Select an option: ";
    }
    public function handleLogIn(?User &$user, array &$credentialDatas) : void{
        echo "\nEnter your email: ";
        $email = readline();
        echo "Enter your password: ";
        $password = readline();
        foreach ($credentialDatas as $data){
            $values = explode(" ",$data);
            if($values[0]==$email && $values[1]==$password){
                $user = new User();
                $user->email = $values[0];
                $user->password = $values[1];
                $user->type = $values[2];
                $user->name = $values[3];
                echo "Login successful as $email !\n";
                return;
            }
        }
        echo "Invalid credentials !\n";
    }

    public function handleRegister(string $type, array &$credentialDatas) : void {
        echo "\nEnter your email: ";
        $email = readline();
        if(alreadyIsExists($email, $credentialDatas)){
            echo "User already exists for this email !\n";
            return;
        }
        echo "Enter your name: ";
        $name = readline();
        echo "Enter your password: ";
        $password = readline();
        $credentialDatas[] = $email . " " . $password . " " . $type . " " . $name;
        file_put_contents("./Credentials.txt",serialize($credentialDatas));
        echo "Account created sucessfully !\n";
    }
    public function showCustomerOption() : void {
        echo "\nOptions: \n";
        echo "1. My Transactions\n";
        echo "2. Deposit Money\n";
        echo "3. Withdraw Money\n";
        echo "4. Transfer Money\n";
        echo "5. My Balance\n";
        echo "0. exit\n";
        echo "Select an option: ";
    }
    public function calculateBalance(User &$user, array &$transactionDatas):float {
        $balance = 0.0;
        foreach ($transactionDatas as $transactionData){
            $values = explode(" ",$transactionData);
            if($values[0] != $user->email) continue;
            if($values[1]=="deposited" || $values[1]=="received") $balance = $balance+floatval($values[3]);
            if($values[1]=="withdrawn" || $values[1]=="sent") $balance = $balance+floatval($values[3]);
        }
        return $balance;
    }
    public function checkEmailExistence(&$credentialDatas, $email):bool {
        foreach ($credentialDatas as $credentialData) {
            $values = explode(" ",$credentialData);
            if($values[0]==$email) return true;
        }
        return false;
    }
    public function showAdminOptions():void {
        echo "\nOptions: \n";
        echo "1. See All Transactions\n";
        echo "2. See A Customer's Tranctions\n";
        echo "3. See All Customers List\n";
        echo "0. exit\n";
    }
}

function alreadyIsExists(string $email, array &$credentialDatas) : bool{
    foreach ($credentialDatas as $data){
        $values = explode($data," ");
        if($values[0]==$email) return true;
    }
    return false;
}