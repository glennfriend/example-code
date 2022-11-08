<?php



class MemoryUsageAnalyzer // Eddie
{
  public function getMemoryUsage(): string  // Eric
  {
      $size = memory_get_usage(true);
      $unit = array('b','kb','mb','gb','tb','pb');
      $index = floor(log($size, 1024));

      return round($size / pow(1024, $index), 2) . ' ' . $unit[$index];
  }
}

