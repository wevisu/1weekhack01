<?php
/**
 * このプログラムはパスワードを１つ自動生成するプログラムです。
 */

//初期化処理
$word = "";

//パスワードを生成するためのタネとなる文字列を用意する
$lowerCaseList   = "abcdefghijkmnpqrstuxyz";
$upperCaseList   = "ABCDEFGHIJKLMNPQRSTUXY";
$numberList      = "23456789";
$specialCharList = "-_";

//文字の塊を連結して１つの文字列とする
$characterList = $lowerCaseList. $upperCaseList. $numberList. $specialCharList;

//乱数のシードを指定する
mt_srand();

//10文字の乱数を作成する
for ($i=0; $i<10; $i++) {
    //0から文字数番目で乱数を生成する（この段階では数字を返す）
    $random = mt_rand(0, (strlen($characterList)));

    //乱数で取得した数字番目の文字を１つ文字列の塊から取得する
    $word .= substr($characterList, $random, 1);
}

var_dump($word);
