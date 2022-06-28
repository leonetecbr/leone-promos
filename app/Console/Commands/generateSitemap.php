<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use App\Helpers\SitemapHelper;

class generateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gera o sitemap';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @throws Exception
     */
    public function handle()
    {
        SitemapHelper::generate();
        $this->line('<fg=green>Sitemap gerado com sucesso.</>');
    }
}
