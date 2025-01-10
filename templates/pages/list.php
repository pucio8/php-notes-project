<div>
  <section>
    <div class='message' >
      <?php
      if (!empty($params['before'])) {
        switch ($params['before']){
          case 'created':
            echo 'Notatka została uwtorzona!';
            break;
          case 'edited':
            echo 'Notatka została edytowana';
            break;
          case 'deleted':
            echo 'Notatka została usunieta';
            break;
          }
        }
        ?>
    </div>
    <div class='message error' >
      <?php
      if (!empty($params['error'])) {
        switch ($params['error']){
          case 'notFoundException':
            echo 'Nie znaleziono takiej notatki!';
            break;
          case 'appException':
            echo 'Błędny adres URL';
            break;
          }
        }
        ?>
    </div>

    <?php 
    $sort = $params['sort'] ?? [];
    $by = $sort['by'];
    $order = $sort['order'];

    $page = $params['page'] ?? [];
    $pages = (int)$page['pages'] ?? 1;
    $currentPage = (int)$page['pageNumber'] ?? 1;

    $phrase = $params['phrase'] ?? null;
    ?>

    <div>
      <form id="settings-form" action="/" method="get">
        <div>
          <label for= "phrase">Wyszukaj: </label>
          <input type="text" id= "phrase" name = "phrase" value = "<?php echo $phrase ?>"> 
        </div>
        <div>
          <label for="sort-by">Sortuj po</label>
          <select name="sort_by" id="sort-by">
            <option value="created" <?php echo $by === 'created' ? 'selected' : ''?>>Dacie</option>
            <option value="title" <?php echo $by === 'title' ? 'selected' : ''?>>Tytule</option>
          </select>

        </div>
        <div>
        <label for="sort-order">Kierunek sortowania</label>
          <select name="sort_order" id="sort-order">
            <option value="asc" <?php echo $order === 'asc' ? 'selected' : ''?>>Rosnący</option>
            <option value="desc" <?php echo $order === 'desc' ? 'selected' : ''?>>Malejący</option>
          </select>
        </div>
        <div>
          <input type="submit" value="Wyślij">
        </div>
      </form>
    </div>

    <div class='tbl-header'>
      <table cellpadding='0' cellspacing='0' border='0'>
        <thead>
          <tr>
            <!-- <th>ID</th> -->
            <th>Title</th>
            <th>Created</th>
            <th>Options</th>
          </tr>
        </thead>
      </table>
      <div class='tbl-content'>
        <table cellpadding='0' cellspacing='0' border='0'>
          <tbody>
            <?php foreach ($params['notes'] ?? [] as $note): ?>
              <tr>
                <!-- <td><?php echo $note['id']?></td> -->
                <td><?php echo $note['title']?></td>
                <td><?php echo $note['created']?></td>
                <td><a href="/?action=show&id=<?php echo $note['id']?>"><button>Show</button></a>
                <a href="/?action=delete&id=<?php echo $note['id']?>"><button>Delete</button></a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <?php 
    $pagitationUrl = "phrase=$phrase&sort_by=$by&sort_order=$order";
    ?>

    <ul class='pagination'>
      <?php if ($currentPage !== 1) : ?>
      <li>
        <a href="/?page=<?php echo ($currentPage - 1) . $pagitationUrl?>">
          <button><<</button>
        </a>
      </li>
      <?php endif; ?>
      <?php for ($i = 1; $i <= $pages; $i++) : ?>
        <li>
          <a href="/?page=<?php echo $i . $pagitationUrl ?>">
            <button><?php echo $i ?></button>
          </a>
        </li>
      <?php endfor; ?>
      <?php if ($currentPage !== $pages ) : ?>
      <li>
        <a href="/?page=<?php echo ($currentPage + 1) . $pagitationUrl ?>">
          <button>>></button>
        </a>
      </li>
      <?php endif; ?>
    </ul>
  </section>
</div>