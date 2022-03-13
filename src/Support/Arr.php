<?php declare(strict_types=1);

namespace App\Support;

class Arr
{
  public static function every(array $haystack, ?callable $callback)
  {
    return !in_array(
      false, 
      array_map(
        function($item, $key) use($callback) {
          if(is_null($callback)) return $item;
          return $callback($item, $key);
        },
          $haystack, 
          array_keys($haystack)));
  }

  public static function find(array $haystack, callable $callback)
  {
    $filtered = array_values(array_filter($haystack, $callback));
    if(empty($filtered)) return null;
    return $filtered[0];
  }

  public static function exists(array $haystack, callable $callback)
  {
    $filtered = array_filter($haystack, $callback);
    return !empty($filtered);
  }
}

