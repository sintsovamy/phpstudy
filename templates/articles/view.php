<?php include __DIR__ . '/../header.php'; ?>
    <h1><?= $article->getName() ?></h1>
    <p><?= $article->getText() ?></p>
    <?php if ($user !== null && $user->getRole() == 'admin') {
    echo '<a href="/articles/' . $article->getId() . '/edit">Редактировать</a>';} ?>
    <p>Автор: <?= $article->getAuthor()->getNickname() ?></p>
    <br>
    <br>
    <form action="/articles/<?= $article->getId()?>/comments" method="post">
    <label for="text">Оставьте комментарий</label><br>
    <textarea name="text" id="text" rows="10" cols="40"><?= $_POST['text'] ?? '' ?></textarea><br> 
    <input type="submit" value="Отправить">
     </form>

    <?php foreach ($comments as $comment): ?>
        <p><?= $comment->getText() ?></p>
	<h3><?= $comment->getAuthor()->getNickname() ?></h3>
    <?php if ($user !== null && ($user->getRole() == 'admin' || $user->getNickname() == $article->getAuthor()->getNickname())) {
    echo '<a href="/comments/' . $comment->getId() . '/edit">Редактировать</a>';} ?>

        <hr>
   <?php endforeach; ?>
        <br>
<?php include __DIR__ . '/../footer.php'; ?>
