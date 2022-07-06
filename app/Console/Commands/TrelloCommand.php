<?php

namespace App\Console\Commands;

use App\Helper\Trello;
use Illuminate\Console\Command;

class TrelloCommand extends Command
{
    use Trello;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Trello:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Archive Card On Trello ';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       $this->deleteArchiveCards();

        return 0;
    }
}
