<?php
include "vars.php";
?>
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="utf-8">
  <title>Створення</title> <link rel="stylesheet" href="css/style.css">

  <style>
    #create-object-form {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    #create-object-form input,
    #create-object-form textarea {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-family: sans-serif;
    }
    #create-object-form button {
        padding: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    #feedback-message {
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
      <h3>Створити новий об'єкт</h3>
      <p>Введіть дані та натисніть "Зберегти".</p>
      
      <form id="create-object-form">
        <label for="note-title">Заголовок:</label>
        <input type="text" id="note-title" required>

        <label for="note-content">Вміст:</label>
        <textarea id="note-content" rows="4" required></textarea>

        <button type="submit">Зберегти</button>
      </form>
      
      <div id="feedback-message"></div>
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
    const noteForm = document.getElementById('create-object-form');
    const feedback = document.getElementById('feedback-message');

    noteForm.addEventListener('submit', function(event) {
        event.preventDefault(); 

        const myObject = {
            title: document.getElementById('note-title').value,
            content: document.getElementById('note-content').value,
            timestamp: new Date().toISOString()
        };

        feedback.textContent = 'Збереження';
        feedback.style.color = 'gray';

        fetch('save.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(myObject) 
        })
        .then(response => response.json())
        .then(data => {
            console.log('Success:', data);
            feedback.textContent = 'Об\'єкт успішно збережено!';
            feedback.style.color = 'green';
            noteForm.reset(); 
            
            setTimeout(() => { feedback.textContent = ''; }, 3000);
        })
        .catch((error) => {
            console.error('Error:', error);
            feedback.textContent = 'Помилка збереження.';
            feedback.style.color = 'red';
        });
    });
  </script>
  </body>
</html>