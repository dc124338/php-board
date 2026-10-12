
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>掲示板</title>
</head>
<body>
    <h1>掲示板</h1>

    <p><strong>パスワードを必ず設定してください。</strong></p>

    <?php if ($message !== ''): ?>
        <p>
            <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endif; ?>

    <h2>投稿・更新</h2>
    <form action="board.php" method="POST">
        <input type="hidden" name="action" value="post">

        編集中の投稿のID：
        <input
            type="text"
            name="update_id"
            value="<?= htmlspecialchars((string)$edit_id, ENT_QUOTES, 'UTF-8') ?>"
            readonly
        >
        <br><br>

        <input
            type="text"
            name="name"
            placeholder="名前を入力"
            maxlength="32"
            value="<?= htmlspecialchars($edit_name, ENT_QUOTES, 'UTF-8') ?>"
            required
        >

        <input
            type="text"
            name="comment"
            placeholder="コメントを入力"
            value="<?= htmlspecialchars($edit_comment, ENT_QUOTES, 'UTF-8') ?>"
            required
        >

        <input
            type="password"
            name="pass"
            placeholder="パスワード"
            required
        >

        <button type="submit">送信</button>
    </form>

    <hr>

    <h2>投稿の削除</h2>
    <form action="board.php" method="POST">
        <input type="hidden" name="action" value="delete">

        <input
            type="number"
            name="number"
            placeholder="削除する投稿のID"
            min="1"
            required
        >

        <input
            type="password"
            name="pass"
            placeholder="パスワード"
            required
        >

        <button type="submit">削除</button>
    </form>

    <hr>

    <h2>投稿の編集</h2>
    <form action="board.php" method="POST">
        <input type="hidden" name="action" value="edit">

        <input
            type="number"
            name="edit"
            placeholder="編集する投稿のID"
            min="1"
            required
        >

        <input
            type="password"
            name="pass"
            placeholder="パスワード"
            required
        >

        <button type="submit">編集</button>
    </form>

    <hr>

    <h2>投稿一覧</h2>

    <?php foreach ($posts as $row): ?>
        <div>
            <p>
                ID：
                <?= htmlspecialchars((string)$row['id'], ENT_QUOTES, 'UTF-8') ?>
                <br>

                名前：
                <?= htmlspecialchars($row['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                <br>

                コメント：
                <?= nl2br(htmlspecialchars($row['comment'] ?? '', ENT_QUOTES, 'UTF-8')) ?>
                <br>

                投稿日時：
                <?= htmlspecialchars($row['date'] ?? '', ENT_QUOTES, 'UTF-8') ?>
            </p>
            <hr>
        </div>
    <?php endforeach; ?>
</body>
</html>