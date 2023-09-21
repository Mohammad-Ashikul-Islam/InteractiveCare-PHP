<?php
// --> Method-1 <--
$userInput = $argv[1];
(int) $character_count = 0;
(int) $i = 0;
for($i=0; $i<strlen($userInput); $i++){
    if( ctype_upper($userInput[$i]) || ctype_lower($userInput[$i]) ) $character_count++;
}
echo "Number of alphabets in the string is: {$character_count}";

/*
 // --> Method-2 <--
echo "Enter the string: ";
(string) $userInput = readline();
(int) $character_count = 0;
(int) $i = 0;
for($i=0; $i<strlen($userInput); $i++){
    if( ctype_upper($userInput[$i]) || ctype_lower($userInput[$i]) ) $character_count++;
}
echo "Number of alphabets in the string is: {$character_count}";

*/