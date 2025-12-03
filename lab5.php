<?php
include "vars.php";
?>
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="utf-8">
  <title>Лаба 5</title>
  <link rel="stylesheet" href="css/style.css">

  <style>
    #object-container {
        position: relative; 
        height: 250px;
        background: #f4f4f4;
        border: 1px solid #ccc;
        overflow: hidden;
    }
    #draggable {
        position: absolute; 
        width: 100px;
        height: 100px;
        background: #007bff;
        color: white;
        text-align: center;
        line-height: 100px;
        cursor: grab;
        user-select: none; 
        top: 10px;
        left: 10px;
    }
    #draggable.dragging {
        background: #0056b3;
        cursor: grabbing;
    }
    #sync-button {
        margin-top: 10px;
        padding: 10px;
        font-size: 1rem;
        cursor: pointer;
    }
    #event-counter {
        margin-top: 10px;
        font-weight: bold;
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
      <p>Натисніть і перетягніть синій квадрат. Кожен рух миші - це "подія", яка фіксується двома способами.</p>
      
      <div id="object-container">
        <div id="draggable">Тягни мене</div>
      </div>
      
      <div id="event-counter">Кількість подій: 0</div>
      
      <button id="sync-button">Відправити дані з LocalStorage на сервер</button>
      <button id="clear-data">Очистити всі логи</button>
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
    const draggable = document.getElementById('draggable');
    const container = document.getElementById('object-container');
    const eventCounterElement = document.getElementById('event-counter');
    const syncButton = document.getElementById('sync-button');
    const clearButton = document.getElementById('clear-data');
    
    let isDragging = false;
    let eventCounter = 0; 

    draggable.addEventListener('mousedown', (e) => {
        isDragging = true;
        draggable.classList.add('dragging');

        clearAllLogs(); 
    });

    window.addEventListener('mouseup', () => {
        isDragging = false;
        draggable.classList.remove('dragging');
    });

    container.addEventListener('mousemove', (e) => {
        if (!isDragging) return;

        let x = e.clientX - container.getBoundingClientRect().left - (draggable.offsetWidth / 2);
        let y = e.clientY - container.getBoundingClientRect().top - (draggable.offsetHeight / 2);

        x = Math.max(0, Math.min(x, container.offsetWidth - draggable.offsetWidth));
        y = Math.max(0, Math.min(y, container.offsetHeight - draggable.offsetHeight));

        draggable.style.left = `${x}px`;
        draggable.style.top = `${y}px`;
        eventCounter++;
        eventCounterElement.textContent = `Кількість подій: ${eventCounter}`;
        
        const eventData = {
            id: eventCounter,
            x: x,
            y: y
        };

        fetch('save_immediate.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(eventData)
        });

        saveToLocalStorage(eventData);
    });

    function saveToLocalStorage(data) {
 
        let log = JSON.parse(localStorage.getItem('eventLog') || '[]');
        data.local_time = new Date().toISOString(); 
        log.push(data);
        
        localStorage.setItem('eventLog', JSON.stringify(log));
    }

    syncButton.addEventListener('click', () => {
        const log = localStorage.getItem('eventLog');
        if (!log || log === '[]') {
            alert('В LocalStorage немає даних для відправки.');
            return;
        }
        
        console.log('Відправляю дані з LocalStorage...', log);
        
        fetch('save_localstorage.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: log 
        })
        .then(res => res.json())
        .then(data => {
            alert('Дані з LocalStorage успішно збережено на сервері!');
            console.log(data);
        })
        .catch(err => console.error('Помилка відправки:', err));
    });
    clearButton.addEventListener('click', clearAllLogs);

    function clearAllLogs() {
        localStorage.removeItem('eventLog'); 
        fetch('save_immediate.php?clear=true'); 
        fetch('save_localstorage.php?clear=true'); 
        eventCounter = 0;
        eventCounterElement.textContent = 'Кількість подій: 0';
        console.log('Всі логи очищено.');
    }
    
  </script>
  </body>
</html>