<?php
include "vars.php";
?>
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="utf-8">
  <title>Відображення</title> <link rel="stylesheet" href="css/style.css">

  <style>
    #objects-container {
        display: flex;
        flex-direction: column; 
        gap: 10px; 
        width: 100%;
    }
    .note {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 10px;
        background: #f9f9f9;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .note h3 {
        margin-top: 0;
        margin-bottom: 5px;
        color: #333;
    }
    .note p {
        margin: 0;
        color: #555;
    }
  </style>
  </head>
<body>
  <div class="container">
    <div class="block b1">
      <span class="small-box"><?= $x ?></span>
      <div><?= $text1 ?></div>
    </div>

    <div class="block b2">
      <?= $text2 ?>
    </div>

    <div class="block b3">
      <ul>
        <?php foreach ($menu as $link => $name): ?>
          <li><a href="<?= $link ?>"><?= $name ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div class="block b4">
        <h3>Динамічні об'єкти з сервера</h3>
        <p>Цей блок оновлюється кожні 5 сек.</p>
      
        <div id="objects-container" style="margin-top: 15px;">
            Завантаження...
        </div>
    </div>
    <div class="block b6">
      <?= $text6 ?>
    </div>

    <div class="block b5">
      <?= $text5 ?>
    </div>


    <div class="block b7">
      <div><?= $text7 ?></div>
      <span class="small-box"><?= $y ?></span>
    </div>
  </div>

  <script>
    const container = document.getElementById('objects-container');
    let lastDataString = '';

    function loadAndDisplayObjects() {
        
        fetch('get.php') 
            .then(response => response.json()) 
            .then(data => {
                
                const currentDataString = JSON.stringify(data);

                if (currentDataString === lastDataString) {
                    return; 
                }
                
                lastDataString = currentDataString; 
                console.log('Отримано нові дані, перемальовуємо HTML...');

                container.innerHTML = ''; 

                if (data.length === 0) {
                    container.textContent = 'На сервері ще немає об\'єктів.';
                }

                data.forEach(obj => {
                    const noteDiv = document.createElement('div');
                    noteDiv.className = 'note'; 

                    const titleEl = document.createElement('h3');
                    titleEl.textContent = obj.title || 'Без назви'; 

                    const contentEl = document.createElement('p');
                    contentEl.textContent = obj.content || 'Немає вмісту';

                    noteDiv.appendChild(titleEl);
                    noteDiv.appendChild(contentEl);
                    container.appendChild(noteDiv);
                });
            })
            .catch(error => {
                console.error('Помилка завантаження даних:', error);
                container.textContent = 'Не вдалося завантажити дані.';
                container.style.color = 'red';
            });
    }
    
    document.addEventListener('DOMContentLoaded', loadAndDisplayObjects);

    setInterval(loadAndDisplayObjects, 5000); 

  </script>
  </body>
</html>