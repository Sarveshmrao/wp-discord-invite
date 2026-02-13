<?php

/**
 * This file is included with WP Discord Invite WordPress Plugin (https://wordpress.com/plugins/wp-discord-invite), Developed by Sarvesh M Rao (https://sarveshmrao.in/).
 * This file is licensed under Generl Public License v2 (GPLv2)  or later.
 * Using the code on whole or in part against the license can lead to legal prosecution.
 * 
 * Sarvesh M Rao
 * https://sarveshmrao.in/
 */

if (!defined("ABSPATH")) {
  exit();
}

/**
 * Calculate time elapsed since a given datetime
 * 
 * @param string $datetime The datetime string to calculate from
 * @param bool $full Whether to return full elapsed time or just the largest unit
 * @return string Human-readable time elapsed string
 */
function time_elapsed_string($datetime, $full = false)
{
  if ($datetime == "Never") {
    return $datetime;
  }
  $now = new DateTime();
  $ago = new DateTime($datetime);
  $diff = $now->diff($ago);

  // Calculate weeks from days
  $weeks = floor($diff->d / 7);
  $days = $diff->d - ($weeks * 7);

  $string = [
    "y" => "year",
    "m" => "month",
    "w" => "week",
    "d" => "day",
    "h" => "hour",
    "i" => "minute",
    "s" => "second",
  ];
  
  // Build time string with actual values
  $time_values = [
    "y" => $diff->y,
    "m" => $diff->m,
    "w" => $weeks,
    "d" => $days,
    "h" => $diff->h,
    "i" => $diff->i,
    "s" => $diff->s,
  ];
  
  foreach ($string as $k => &$v) {
    if ($time_values[$k]) {
      $v = $time_values[$k] . " " . $v . ($time_values[$k] > 1 ? "s" : "");
    } else {
      unset($string[$k]);
    }
  }

  if (!$full) {
    $string = array_slice($string, 0, 1);
  }
  return $string ? implode(", ", $string) . " ago" : "just now";
}

?>