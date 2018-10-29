<?php
namespace mkulichkin\infinitySum;

$augend = '9230000';
$addend = '99';

try {
  $sum = infinitySum($augend, $addend);
  assert(infinitySum('92300000000000', '99') == 92300000000099,
    'Неверный результат сложения!');

  assert(infinitySum('9', '99') == 108,
    'Неверный результат сложения!');

  echo $augend . ' + ' . $addend . " = " . $sum;

}
catch (Exception $e) {
  echo 'Выброшено исключение: ', $e->getMessage(), "\n";
}

/**
 * Функция для сложения двух огромных положительных целых чисел.
 *
 * PHP 7 - минимум.
 *
 * @param string $augend
 *   Первое слагаемое.
 * @param string $addend
 *   Второе слагаемое.
 *
 * @return string
 *   Сумма слагаемых.
 *
 * @throws \Exception
 */
function infinitySum(string $augend, string $addend) {

  $result = [];

  if (!(ctype_digit($augend) && ctype_digit($addend))) {
    throw new Exception('Строки операндов не являются положительными целыми числами.');
  }

  $firstLen = strlen($augend);
  $secondLen = strlen($addend);

  $maxLength = $firstLen > $secondLen ? $firstLen : $secondLen;

  /*
   * У нас в строках только цифры, поэтому все символы однобайтовые.
   * Меняем порядок символов на обратный и превращаем в массив.
   */
  $arFirst = str_split(strrev($augend));
  $arSecond = str_split(strrev($addend));

  $next = 0;

  for ($pos = 0; $pos < $maxLength; $pos++) {
    $firstEl = $arFirst[$pos] ?? 0;
    $secondEl = $arSecond[$pos] ?? 0;

    $sum = $firstEl + $secondEl + $next;

    if ($sum > 9) {
      $sum -= 10;
      $next = 1;
    }
    else {
      $next = 0;
    }

    $result[$pos] = $sum;
  }

  // Добавляем старший разряд, если нужно.
  if ($next) {
    $result[$pos] = 1;
  }

  return implode(array_reverse($result));
}
