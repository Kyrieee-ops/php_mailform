<?php
    session_start();


    //文字列のエスケープ処理
    function h($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
    
    //エラー配列変数
    $error = [];
    //POSTで送られているかどうかのチェック（GETの場合にはエラーメッセージを表示させたくない為）
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //フォーム送信時にエラーチェック
        //$_POSTの値をまとめて取得してバリバリデーションチェック
        $post = filter_input_array(INPUT_POST, $_POST);
        if ($post['name'] === '') {
            $error['name'] = 'blank';
        }

        if ($post['email'] === '') {
            $error['email'] = 'blank';
            //メールアドレスの形式ではない場合
        } else if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
            $error['email'] = 'email';
        }

        if ($post['contact'] === '') {
            $error['contact'] = 'blank';
        }

            //エラーがない場合
        if (count($error) === 0) {
            $_SESSION['form'] = $post;
            header('Location: confirm.php');
            exit();
        }
        //GETで渡された場合⇒戻るボタンを押下の場合
    } else {
        if (isset($_SESSION['form'])){
            $post = $_SESSION['form'];
        }
    }

    

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>お問合せフォーム</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="contact.css">
</head>
<body>
    <!-- お問合せフォーム画面 -->
    <div class="container">
        <form action="" method="POST" novalidate>
            <p>お問い合わせ</p>
            <div class="form-group">
                <div class="row">
                    <div class="col-2">
                        <label for="inputName">お名前</label>
                    </div>
                    <div class="col-2">
                        <p class="require_item">必須</p>
                    </div>
                    <div class="col-8">
                        <input type="text" name="name" id="inputName" class="form-control" value="<?php echo h($post['name']); ?>" required autofocus>
                        <?php if ($error['name'] === 'blank'): ?>
                            <p class="error_msg">※お名前をご記入下さい</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-2">
                        <label for="inputEmail">メールアドレス</label>
                    </div>
                    <div class="col-2">
                        <p class="require_item">必須</p>
                    </div>
                    <div class="col-8">
                        <input type="email" name="email" id="inputEmail" class="form-control" value="<?php echo h($post['email']); ?>" required>
                        <?php if ($error['email'] === 'blank'): ?>
                            <p class="error_msg">※メールアドレスをご記入下さい</p>
                        <?php elseif($error['email'] === 'email'):?>
                            <p class="error_msg">※メールアドレスの形式で入力して下さい</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-2">
                        <label for="inputContent">お問い合わせ内容</label>
                    </div>
                    <div class="col-2">
                        <p class="require_item">必須</p>
                    </div>
                    <div class="col-8">
                        <textarea name="contact" id="inputContent" rows="10" class="form-control" required><?php echo h($post['contact']); ?></textarea>
                        <?php if ($error['contact'] === 'blank'): ?>
                            <p class="error_msg">※お問い合わせ内容をご記入下さい</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-8 offset-4">
                    <button type="submit">確認画面へ</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>