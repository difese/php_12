<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <title>★ ЧТД (ЧеловекоТипыДанных) ★</title>
    <link rel="stylesheet" href="./css/style.css" type="text/css">
    <link rel="icon" href="./images/favicon.ico">
  </head>

  <body class="body">
    <div class="container">

    <?php require 'functions.php'; ?>

      <ul class="functions__list">
        <li class="function__item task1">
          <div class="function__title">1. Разбиение и объединение ФИО</div>
          <div class="function__info">
            Функция <code class="code">getPartsFromFullname</code> принимает как
            аргумент одну строку - склеенное ФИО, а возвращает как результат
            массив из трёх элементов с ключами 'name', 'surname' и 'patronymic'.
            Например, как аргумент принимается строка "Семёнов Семён
            Семёнович", а возвращается массив ['surname' => 'Семёнов' ,'name' =>
            'Семён', 'patronymic' => 'Семёнович'].
          </div>
          <div class="function__result">
            <div class="result__title">
              Результат выполнения функции
              <code class="code">getPartsFromFullname</code>:
            </div>
            <div class="result__content">

              <!-- Семёнов
              <br>
              Семён
              <br>
              Семёнович -->

              <?php
                getPartsFromFullname($randomPerson);
                echo $personNameParts['surname'];
                echo '<br>';
                echo $personNameParts['name'];
                echo '<br>';
                echo $personNameParts['patronymic'];
              ?>

            </div>
          </div>
          <div class="function__info">
            Функция <code class="code">getFullnameFromParts</code> принимает как
            аргумент три строки - фамилию, имя и отчество, а возвращает как
            результат их же, но склеенные через пробел.
            Например, как аргументы принимаются три строки "Семёнов", "Семён" и
            "Семёнович", а возвращается одна строка - "Семёнов Семён Семёнович".
          </div>
          <div class="function__result">
            <div class="result__title">
              Результат выполнения функции
              <code class="code">getFullnameFromParts</code>:
            </div>
            <div class="result__content">

              <!-- Семёнов Семён Семёнович -->

              <?php
                $surname = $personNameParts['surname'];
                $name = $personNameParts['name'];
                $patronymic = $personNameParts['patronymic'];
                getFullnameFromParts($surname, $name, $patronymic);
                echo $personFullName;
              ?>

            </div>
          </div>
        </li>

        <li class="function__item task2">
          <div class="function__title">2. Сокращение ФИО</div>
          <div class="function__info">
            Функция <code class="code">getShortName</code> принимает как
            аргумент строку, содержащую ФИО вида "Семёнов Семён Семёнович",
            возвращает как результат строку вида "Семён С.", где сокращается
            фамилия и отбрасывается отчество.
            Для разбиения строки на составляющие используется функция
            <code class="code">getPartsFromFullname</code>.
          </div>
          <div class="function__result">
            <div class="result__title">
              Результат выполнения функции
              <code class="code">getShortName</code>:
            </div>
          </div>
          <div class="result__content">

            <!-- Семён С. -->

            <?php
              getShortName($randomPerson);
              echo $personShortName;
            ?>

          </div>
        </li>

        <li class="function__item task3">
          <div class="function__title">3. Определение пола по ФИО</div>
          <div class="function__info">
            Функция <code class="code">getGenderFromName</code> принимает как
            аргумент строку, содержащую ФИО (вида "Семёнов Семён Семёнович") и
            проверяет на признаки мужского и женского пола.
            Как результат возвращает '-1' (женский пол),
            '1' (мужской пол) или '0' (неопределённый пол).
            Внутри функции делим ФИО на составляющие с помощью функции
            <code class="code">getPartsFromFullname</code>.
          </div>
          <div class="function__result">
            <div class="result__title">
              Результат выполнения функции
              <code class="code">getGenderFromName</code>:
            </div>
            <div class="result__content">

              <!-- мужской пол-->

              <?php
                getGenderFromName($randomPerson);
                if ($genderFromName === -1) {
                  echo '<div>женский пол</div>';
                }
                elseif ($genderFromName === 1) {
                  echo '<div>мужской пол</div>';
                }
                elseif ($genderFromName === 0) {
                  echo '<div>неопределённый пол</div>';
                }
              ?>

            </div>
          </div>
        </li>

        <li class="function__item task4">
          <div class="function__title">4. Определение гендерного состава</div>
          <div class="function__info">
            В функцию <code class="code">getGenderDescription</code> как
            аргумент передаётся массив, как результат функции возвращается
            информация о гендерном составе аудитории.
            Используется функция <code class="code">getGenderFromName</code>.
          </div>
          <div class="function__result">
            <div class="result__title">
              Результат выполнения функции
              <code class="code">getGenderDescription</code>:
            </div>
            <div class="result__content">

              <!-- Гендерный состав аудитории:
              <br>
              ---------------------------
              <br>
              Мужчины - 54.5%
              <br>
              Женщины - 27.3%
              <br>
              Не удалось определить - 18.2% -->

              <?php
                getGenderDescription($example_persons_array);
                echo $genderDescription;
              ?>

            </div>
          </div>
        </li>

        <li class="function__item task5">
          <div class="function__title">5. "Идеальный" подбор пары</div>
          <div class="function__info">
            В функцию <code class="code">getPerfectPartner</code> как первые три
            аргумента передаются строки с фамилией, именем и отчеством (именно в
            этом порядке), при этом регистр может быть любым (СЕМЁНОВ СЕМЁН
            СЕМЁНОВИЧ, семёнов СеМён Семёнович), четвёртый аргумент - в функцию
            передаётся массив.
            Как результат выполнения функции случайный образом выбирается любой
            человек из массива (противоположного пола) и возвращается информация
            об "идеальной" совместимости - случайное число от 50% до 100% (с
            точностью два знака после запятой).
            ФИО склеивается, используя функцию
            <code class="code">getFullnameFromParts</code>, пол для ФИО (а также
            полную противоположность пола партнёра) определяем с помощью функции
            <code class="code">getGenderFromName</code>.
          </div>
          <div class="function__result">
            <div class="result__title">
              Результат выполнения функции
              <code class="code">getPerfectPartner</code>:
            </div>
            <div class="result__content">

              <!-- Семён С. + Грейс К. =
              <br>
              ♡ Идеально на 99.99% ♡ -->

              <?php
                getPerfectPartner ($surname, $name, $patronymic, $example_persons_array);
                echo $perfectPartner;
              ?>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </body>
</html>
