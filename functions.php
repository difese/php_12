<?php include 'array.php';

// Случайно выбираем персону (ФИО) из массива
$randomPerson = $example_persons_array[random_int(0, count($example_persons_array) - 1)]['fullname']; // string
// echo var_dump($randomPerson);


// Разбиение ФИО
function getPartsFromFullname($randomPerson) {
  global $personNameParts;
  $personNameParts =
  [
    'surname' => explode(' ', $randomPerson)[0],
    'name' => explode(' ', $randomPerson)[1],
    'patronymic' => explode(' ', $randomPerson)[2]
  ];
  return $personNameParts;
}

// Объединение ФИО из частей (конкатенация)
function getFullnameFromParts($surname, $name, $patronymic) {
  global $personFullName;
  $personFullName = $surname . ' ' . $name . ' ' . $patronymic;
  return $personFullName;
}

// Сокращение ФИО (mb_substr - возвращает часть строки)
function getShortName($randomPerson) {
  global $personShortName;
  $personShortName = getPartsFromFullname($randomPerson)['name'] .' '. mb_substr(getPartsFromFullname($randomPerson)['surname'], 0, 1) . '.';
  return $personShortName;
}

// Определение пола по ФИО (<=> - космический корабль <-1, 0, 1>)
function getGenderFromName($randomPerson) {
  $genderCount = 0;
  $surname = getPartsFromFullname($randomPerson)['surname'];
  $name = getPartsFromFullname($randomPerson)['name'];
  $patronymic = getPartsFromFullname($randomPerson)['patronymic'];
  if (mb_substr($surname, -2) === 'ва') {
    $genderCount--;
  }
  if (mb_substr($name, -1) === 'а') {
    $genderCount--;
  }
  if (mb_substr($patronymic, -3) === 'вна') {
    $genderCount--;
  }
  if (mb_substr($surname, -1) === 'в') {
    $genderCount++;
  }
  if (mb_substr($name, -1) === 'й' || mb_substr($name, -1) === 'н') {
    $genderCount++;
  }
  if (mb_substr($patronymic, -2) === 'ич') {
    $genderCount++;
  }
  global $genderFromName;
  $genderFromName = $genderCount <=> 0;
  return $genderFromName;
}

// Определение гендерного состава аудитории
function getGenderDescription($example_persons_array) {
  foreach ($example_persons_array as $persons) {
    $gender[] = getGenderFromName($persons['fullname']);
  }
  function male($gender) {
    return $gender === 1;
  }
  function female($gender) {
    return $gender === -1;
  }
  $personsCount = count($example_persons_array);
  $menCount = count(array_filter($gender, 'male'));
  $womenCount = count(array_filter($gender, 'female'));
  $men = round($menCount / $personsCount * 100, 1);
  $women = round($womenCount / $personsCount * 100, 1);
  $undefined = 100 - ($men + $women);
  global $genderDescription;
  $genderDescription = <<<MAYBESEX
    Гендерный состав аудитории:
    <br>
    ---------------------------
    <br>
    Мужчины - $men%
    <br>
    Женщины - $women%
    <br>
    Не удалось определить - $undefined%
    MAYBESEX;
  return $genderDescription;
}

// "Идеальный" подбор пары
function getPerfectPartner ($surname, $name, $patronymic, $example_persons_array) {
  $surname = mb_convert_case($surname, MB_CASE_TITLE_SIMPLE);
  $name = mb_convert_case($name, MB_CASE_TITLE_SIMPLE);
  $patronymic = mb_convert_case($patronymic, MB_CASE_TITLE_SIMPLE);
  $personFullName = $surname . ' ' . $name . ' ' . $patronymic;
  $genderPerson = getGenderFromName($personFullName);
  $personShortName = getShortName($personFullName);
  global $perfectPartner;
  if ($genderPerson != 0) {
    do {
      $partnerFullName = mb_convert_case($example_persons_array[random_int(0, count($example_persons_array) - 1)]['fullname'], MB_CASE_TITLE_SIMPLE);
      $genderPartner = getGenderFromName($partnerFullName);
    }
    while ($genderPerson === $genderPartner || $genderPartner === 0);
    $partnerShortName = getShortName($partnerFullName);
    $idealCompatibility = round(random_int(5000, 10000) / 100, 2);
    $perfectPartner = <<<MAYBEYES
      $personShortName + $partnerShortName =
      <br>
      💗 «Идеально» на $idealCompatibility% 💗
      MAYBEYES;
  } else {
    $perfectPartner = <<<MAYBENO
    $personShortName <=> 👽
    <br>
    Не смогли определить пол!
    MAYBENO;
  }
  return $perfectPartner;
}
