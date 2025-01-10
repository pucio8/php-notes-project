<div class= 'show'>
  <h2>Notatka</h2>
  <?php $note = $params['note'] ?? null ?>
  <?php if($note): ?> 
  <ul>
    <li><b>Tytuł: </b><?php echo $note['title']; ?></li>
    <li><?php echo $note['description']; ?></li>
    <li><b>Zapsiano: </b><?php echo $note['created']; ?></li>
  </ul>
  <?php endif; ?>
  <a href="/?action=edit&id=<?php echo $note['id']?>"><button>Edycja</button></a>
  <a href="/"><button>Powrót do listy notatek</button></a>
</div>