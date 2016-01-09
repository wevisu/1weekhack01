<?php
/**
 * このプログラムはパスワードを１つ自動生成するプログラムです。
 */

//初期化処理
$word = "";
$characterList = "";

//パスワードを生成するためのタネとなる文字列を用意する
$upperCaseList   = "ABCDEFGHIJKLMNPQRSTUXY";
$lowerCaseList   = "abcdefghijkmnprstuxyz";
$numberList      = "2345678";
$specialCharList = "-_";


if (empty($_POST['number']) || !is_numeric($_POST['number'])) {
    //有効な数字でない場合はデフォルト値にする
    $_POST['number'] = 10;
} else if ($_POST['number'] > 32) {
    //32文字より大きい場合はMaxの32文字にする
    $_POST['number'] = 32;
}

//パスワードに使用する文字の種類を設定する
if (!empty($_POST['parameter'])) {
    foreach ($_POST['parameter'] as $value) {
        switch ($value) {
            case 1: //「大文字」を連結
                $characterList .=  $upperCaseList;
                break;

            case 2: //「小文字」を連結
                $characterList .=  $lowerCaseList;
                break;

            case 3: //「数字」を連結
                $characterList .=  $numberList;
                break;

            case 4: //「記号」を連結
                $characterList .=  $specialCharList;
                break;
        }
    }
} else {
    //初期は全部入りなのですべての項目にチェックが入っているように設定する
    $_POST['parameter'] = array(1,2,3,4);

    //文字の塊を連結して１つの文字列とする（何も指定がなければ全部入りにする）
    $characterList = $lowerCaseList. $upperCaseList. $numberList. $specialCharList;
}

//乱数のシードを指定する
mt_srand();

//10文字の乱数を作成する
for ($i=0; $i<$_POST['number']; $i++) {
    //0から文字数番目で乱数を生成する（この段階では数字を返す）
    $random = mt_rand(0, (strlen($characterList)));

    //乱数で取得した数字番目の文字を１つ文字列の塊から取得する
    $word .= substr($characterList, $random, 1);
}


/**
 * チェックボックスにチェックされているかを確認する関数
 * @param $pattern
 * @param string $type
 * @return bool|string
 */
function checkActiveButton($pattern, $type = 'checked') {
    //配列になにも入っていなければ抜ける
    if (empty($_POST['parameter'])) {
        return false;
    }

    //チェックボックスにチェックされた回数回ループ動かしてチェックされているか確認する
    foreach ($_POST['parameter'] as $value) {
        //チェックボックスのチェック
        if ($value == $pattern && $type == 'checked') {
            return "checked='checked'";
        }

        //ボタンのクラスのチェック
        if ($value == $pattern && $type == 'active') {
            return " active";
        }
    }

    return false;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Freelancer - Start Bootstrap Theme</title>

    <!-- Bootstrap Core CSS - Uses Bootswatch Flatly Theme: http://bootswatch.com/flatly/ -->
    <link href="_asset/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="_asset/css/freelancer.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="_asset/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top" class="index">

<!-- Navigation -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <a class="navbar-brand" href="https://1weekhack.com" target="_blank">パスワード自動生成</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="page-scroll">
                    <a href="https://1weekhack.com" title="Blog" target="_blank">Blog</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>

<!-- Header -->
<header>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="intro-text">
                    <span class="name" style="word-break:break-all;"><?php echo $word ?></span>
                    <form action="./index.php" method="post">
                        <hr class="star-light">
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default <?php echo checkActiveButton(1, 'active'); ?>"><input type="checkbox" name="parameter[]" value="1" <?php echo checkActiveButton(1); ?>>大文字</label>
                            <label class="btn btn-default <?php echo checkActiveButton(2, 'active'); ?>"><input type="checkbox" name="parameter[]" value="2" <?php echo checkActiveButton(2); ?>>小文字</label>
                            <label class="btn btn-default <?php echo checkActiveButton(3, 'active'); ?>"><input type="checkbox" name="parameter[]" value="3" <?php echo checkActiveButton(3); ?>>数字</label>
                            <label class="btn btn-default <?php echo checkActiveButton(4, 'active'); ?>"><input type="checkbox" name="parameter[]" value="4" <?php echo checkActiveButton(4); ?>>記号</label>
                        </div>
                        <div class="input-group" style="width: 283px; margin-top: 15px; margin-right: auto; margin-left: auto; ">
                            <span class="input-group-addon" id="basic-addon1">文字数</span>
                            <input type="text" class="form-control" name="number" placeholder="10" aria-describedby="basic-addon1" value="<?php echo $_POST['number']; ?>">
                        </div>
                        <hr class="star-light">

                        <input type="hidden" name="flag" value="1">
                        <button type="submit" class="btn btn-default navbar-btn">再表示</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Footer -->
<footer class="text-center">
    <div class="footer-above">
        <div class="container">
            <div class="row">
                <div class="footer-col col-md-12">
                    <h3>Around the Web</h3>
                    <ul class="list-inline">
                        <li>
                            <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-twitter"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-below">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    Copyright &copy; 1WeekHack 2016
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- jQuery -->
<script src="_asset/js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="_asset/js/bootstrap.min.js"></script>

<!-- Plugin JavaScript -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="_asset/js/classie.js"></script>
<script src="_asset/js/cbpAnimatedHeader.js"></script>

<!-- Contact Form JavaScript -->
<script src="_asset/js/jqBootstrapValidation.js"></script>
<script src="_asset/js/contact_me.js"></script>

<!-- Custom Theme JavaScript -->
<script src="_asset/js/freelancer.js"></script>

</body>

</html>
