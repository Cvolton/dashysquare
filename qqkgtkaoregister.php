<?php
//defining variables
include "incl/connection.php";
require_once "incl/getStuff.php";
$gs = new getStuff();
$acc = $gs->getArray($_POST["newAccountInfo"]);
//creating pass hash
CRYPT_BLOWFISH or die ('-2');
//This string tells crypt to use blowfish for 5 rounds.
$Blowfish_Pre = '$2a$05$';
$Blowfish_End = '$';
// Blowfish accepts these characters for salts.
$Allowed_Chars =
'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
$Chars_Len = 63;
$Salt_Length = 21;
$salt = "";
for($i=0; $i < $Salt_Length; $i++)
{
    $salt .= $Allowed_Chars[mt_rand(0,$Chars_Len)];
}
$bcrypt_salt = $Blowfish_Pre . $salt . $Blowfish_End;
$password = crypt($acc["Password"], $bcrypt_salt);
//registering
$query = $db->prepare("INSERT INTO accounts (userName, password, salt, email, TwitterLink, YouTubeLink, TwitchLink, InstagramLink, EXP, SecretKeys, DemonKeys, CharactersUnlocked, GhostLevelsCompleted, TrophiesObtained, LevelsFeatured, LevelsInSpotlight, IsActivated, IsBanned, CustomInfo)
VALUES (:userName, :password, :salt, :email, :TwitterLink, :YouTubeLink, :TwitchLink, :InstagramLink, :EXP, :SecretKeys, :DemonKeys, :CharactersUnlocked, :GhostLevelsCompleted, :TrophiesObtained, :LevelsFeatured, 
:LevelsInSpotlight, 1, 0, :CustomInfo)");

$query->execute([':userName' => $acc["Username"], ':password' => $password, ':email' => $acc["Email"], ':salt' => $salt, ':TwitterLink' => $acc["TwitterLink"], ':YouTubeLink' => $acc["YouTubeLink"], 
':TwitchLink' => $acc["TwitchLink"], ':InstagramLink' => $acc["InstagramLink"], ':EXP' => $acc["EXP"], ':SecretKeys' => $acc["SecretKeys"], ':DemonKeys' => $acc["DemonKeys"], ':CharactersUnlocked' => $acc["CharactersUnlocked"], 
':GhostLevelsCompleted' => $acc["GhostLevelsCompleted"], ':TrophiesObtained' => $acc["TrophiesObtained"], ':LevelsFeatured' => $acc["LevelsFeatured"], ':LevelsInSpotlight' => $acc["LevelsInSpotlight"], ':CustomInfo' => $acc["CustomInfo"]]);
echo "success";
?>