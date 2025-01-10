<div class= 'delete'>
  <h2>Notatka</h2>
  <?php $note = $params['note'] ?? null ?>
  <?php if($note): ?> 
  <ul>
    <li><b>ID: </b><?php echo $note['id']; ?></li>
    <li><b>Tytuł: </b><?php echo $note['title']; ?></li>
    <li><?php echo $note['description']; ?></li>
    <li><b>Zapsiano: </b><?php echo $note['created']; ?></li>
  </ul>
  <?php endif; ?>
  <form action="/?action=delete" method="post">
    <input name = "id" type="hidden" value="<?php echo $note['id']?>">
    <input type="submit" value = "Usuń" id="delete-input">
    <a href="/"><button type = 'button'>Powrót do listy notatek</button></a>
  </form>
</div>