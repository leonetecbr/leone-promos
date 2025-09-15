<?php

namespace App\Console\Commands;

use App\Helpers\SitemapHelper;
use Exception;
use Illuminate\Console\Command;

class GenerateSitemap extends Command
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
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @throws Exception
     */
    public function handle(): void
    {
        SitemapHelper::generate();
        $this->line('<fg=green>Sitemap gerado com sucesso.</>');
    }
}
