<?php

/*
 * This file is part of the Sepiphy package.
 *
 * (c) Nguyễn Xuân Quỳnh <nguyenxuanquynh2210vghy@gmail.com>
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

        return array_filter(
            $commands,
            function ($instance, $command) use ($keyword) {
                $searchByCommand = strpos(strtolower($command), $keyword) !== false;
                $searchByInstance = strpos(strtolower($instance->getDescription()), $keyword) !== false;

                return $searchByCommand || $searchByInstance;
            },
            ARRAY_FILTER_USE_BOTH
        );
    }
}
