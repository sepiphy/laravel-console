<?php declare(strict_types=1);

/*
 * This file is part of the Sepiphy package.
 *
 * (c) Quynh Xuan Nguyen <seriquynh@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sepiphy\Laravel\Console\Commands;

use Illuminate\Console\Command;

class SearchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search {keyword}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Search commands by provided keyword';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $keyword = $this->argument('keyword');
        $commands = $this->search($keyword);

        $headers = [
            'Command',
            'Description',
        ];
        $rows = [];
        foreach ($commands as $key => $value) {
            $rows[] = [
                'command' => $key,
                'description' => $value->getDescription(),
            ];
        }

        $this->info(sprintf("Found %d commands for '%s' keyword", count($commands), $keyword));
        $this->table($headers, $rows);
    }

    /**
     * Search commands by passed keyword.
     *
     * @param  string  $keyword
     * @return array
     */
    protected function search($keyword)
    {
        $commands = $this->getApplication()->all();
        $keyword = strtolower($keyword);
        
        // Search commands using strpos()
        $results = array_filter(
            $commands,
            function ($instance, $command) use ($keyword) {
                $searchByCommand = strpos(strtolower($command), $keyword) !== false;
                $searchByInstance = strpos(strtolower($instance->getDescription()), $keyword) !== false;

                return $searchByCommand || $searchByInstance;
            },
            ARRAY_FILTER_USE_BOTH
        );
        
        // If the above code can't find any command. The findAlternatives function will be called to search.
        if (!count($results)) {
            $suggestions = $this->findAlternatives(
                $keyword,
                array_keys($allCommands = $this->getApplication()->all())
            );
            if (count($suggestions)) {
                $results = array_filter($allCommands, function ($instance, $command) use ($suggestions) {
                    return in_array($command, $suggestions);
                }, ARRAY_FILTER_USE_BOTH);
            }
        }

        return $results;
    }

    /**
     * @see \Symfony\Component\Console\Application::findAlternatives()
     */
    private function findAlternatives($name, $collection)
    {
        $threshold = 1e3;
        $alternatives = [];

        $collectionParts = [];
        foreach ($collection as $item) {
            $collectionParts[$item] = explode(':', $item);
        }

        foreach (explode(':', $name) as $i => $subname) {
            foreach ($collectionParts as $collectionName => $parts) {
                $exists = isset($alternatives[$collectionName]);
                if (!isset($parts[$i]) && $exists) {
                    $alternatives[$collectionName] += $threshold;
                    continue;
                } elseif (!isset($parts[$i])) {
                    continue;
                }

                $lev = levenshtein($subname, $parts[$i]);
                if ($lev <= \strlen($subname) / 3 || '' !== $subname && false !== strpos($parts[$i], $subname)) {
                    $alternatives[$collectionName] = $exists ? $alternatives[$collectionName] + $lev : $lev;
                } elseif ($exists) {
                    $alternatives[$collectionName] += $threshold;
                }
            }
        }

        foreach ($collection as $item) {
            $lev = levenshtein($name, $item);
            if ($lev <= \strlen($name) / 3 || false !== strpos($item, $name)) {
                $alternatives[$item] = isset($alternatives[$item]) ? $alternatives[$item] - $lev : $lev;
            }
        }

        $alternatives = array_filter($alternatives, function ($lev) use ($threshold) {
            return $lev < 2 * $threshold;
        });
        ksort($alternatives, SORT_NATURAL | SORT_FLAG_CASE);

        return array_keys($alternatives);
    }
}
