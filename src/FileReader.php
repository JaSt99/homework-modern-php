<?php

namespace IW\Workshop;

class FileReader
{
    private const PATTERN = '/test\.(\w+)/';

    /**
     * @param string   $filePath
     * @param string[] $filters
     *
     * @return void
     */
    public function readFile(string $filePath, array $filters): void
    {
        if (!is_file($filePath)) {
            echo "Soubor '{$filePath}' nebyl nalezen\n";
        }

        $this->readLines(file($filePath, FILE_SKIP_EMPTY_LINES), $filters);
    }

    /**
     * @param string[] $rows
     * @param string[] $filters
     *
     * @return void
     */
    private function readLines(array $rows, array $filters): void
    {
        $totalRows = count($rows);
        $stats = [];

        foreach ($this->addToStats($rows, $totalRows - 1) as $item) {
            $level = $item['level'];
            $isLast = $item['isLast'];

            if (!in_array($level, $filters, true)) {
                if (array_key_exists($level, $stats)) {
                    $stats[$level]++;
                } else {
                    $stats[$level] = 1;
                }
            }

            if (true === $isLast) {
                arsort($stats);
            }

            foreach ($stats as $levelInStats => $count) {
                echo "$levelInStats: $count" . PHP_EOL;
            }

            if (false === $isLast) {
                system('clear');
            }
        }
    }

    /**
     * @param string[] $rows
     * @param int      $totalRows
     *
     * @return iterable
     */
    private function addToStats(array $rows, int $totalRows): iterable
    {
        $isLast = false;

        foreach ($rows as $key => $row) {
            if (preg_match(self::PATTERN, $row, $matches)) {
                if ($key === $totalRows) {
                    $isLast = true;
                }

                yield [
                    'level' => strtolower($matches[1]),
                    'isLast' => $isLast,
                ];
            }
        }
    }
}
