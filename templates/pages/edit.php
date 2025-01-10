<div>
  <?php if(!empty($params['note'])) : ?>
<?php $note = $params['note'] ;?>
    <h3>Edycja Notatki</h3>
    <div>
    <form class="note-form" action="/?action=edit" method="post">
      <ul>
        <li>
          <input type="hidden" name="id" value=<?php echo $note['id']?>>
          <label>Tytuł <span class="required">*</span></label>
          <input type="text" name="title" class="field-long" value="<?php echo $note['title']?>" />
        </li>
        <li>
          <label>Treść</label>
          <textarea name="description" id="field5" class="field-long field-textarea"><?php echo $note['description']?></textarea>
        </li>
        <li>
          <input type="submit" value="Submit" />
        </li>
      </ul>
    </form>
  </div>
  <?php else: ?>
    <h2>Brak notatek do wyświetlenia</h2>
    <a href="/"><button>Powrót</button></a>
  <?php endif; ?>
</div>