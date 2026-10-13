
<?php
require_once __DIR__ . '/db.php';

$message = '';
$edit_id = '';
$edit_name = '';
$edit_comment = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $pass = $_POST['pass'] ?? '';

    // 投稿、更新
    if ($action === 'post') {
        $name = trim($_POST['name'] ?? '');
        $comment = trim($_POST['comment'] ?? '');
        $update_id = $_POST['update_id'] ?? '';
        $date = date('Y-m-d H:i:s');

        if ($name === '' || $comment === '' || $pass === '') {
            $message = '名前とパスワードを入れてコメントを書いてください。';
        } elseif ($update_id !== '') {
            $stmt = $pdo->prepare(
                'SELECT pass FROM test5 WHERE id = :id'
            );
            $stmt->execute([':id' => $update_id]);
            $row = $stmt->fetch();

            if ($row && $row['pass'] === $pass) {
                $stmt = $pdo->prepare(
                    'UPDATE test5
                     SET name = :name, comment = :comment, date = :date
                     WHERE id = :id'
                );
                $stmt->execute([
                    ':id' => $update_id,
                    ':name' => $name,
                    ':comment' => $comment,
                    ':date' => $date
                ]);
                $message = '投稿を更新しました。';
            } else {
                $message = 'IDまたはパスワードが正しくありません。';
            }
        } else {
            $stmt = $pdo->prepare(
                'INSERT INTO test5 (name, comment, date, pass)
                 VALUES (:name, :comment, :date, :pass)'
            );
            $stmt->execute([
                ':name' => $name,
                ':comment' => $comment,
                ':date' => $date,
                ':pass' => $pass
            ]);
            $message = '投稿しました。';
        }
    }

    // 削除
    elseif ($action === 'delete') {
        $number = $_POST['number'] ?? '';

        if ($number === '' || $pass === '') {
            $message = '削除したいコメントのIDとパスワードを入力してください。';
        } else {
            $stmt = $pdo->prepare(
                'SELECT pass FROM test5 WHERE id = :id'
            );
            $stmt->execute([':id' => $number]);
            $row = $stmt->fetch();

            if ($row && $row['pass'] === $pass) {
                $stmt = $pdo->prepare(
                    'DELETE FROM test5 WHERE id = :id'
                );
                $stmt->execute([':id' => $number]);
                $message = '投稿を削除しました。';
            } else {
                $message = 'IDまたはパスワードが正しくありません。';
            }
        }
    }

    // 編集対象の読み込み
    elseif ($action === 'edit') {
        $edit = $_POST['edit'] ?? '';

        if ($edit === '' || $pass === '') {
            $message = '編集したいコメントのIDとパスワードを入力してください。';
        } else {
            $stmt = $pdo->prepare(
                'SELECT * FROM test5 WHERE id = :id'
            );
            $stmt->execute([':id' => $edit]);
            $row = $stmt->fetch();

            if ($row && $row['pass'] === $pass) {
                $edit_id = $row['id'];
                $edit_name = $row['name'];
                $edit_comment = $row['comment'];
                $message = '内容を編集欄に読み込みました。';
            } else {
                $message = 'IDまたはパスワードが正しくありません。';
            }
        }
    }
}

// 投稿一覧を取得
$stmt = $pdo->query('SELECT * FROM test5 ORDER BY id ASC');
$posts = $stmt->fetchAll();

require __DIR__ . '/templates/board.php';
