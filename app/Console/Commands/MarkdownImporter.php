<?php

namespace App\Console\Commands;

use App\Domains\Utils\Markdown\Contracts\MarkdownParser;
use App\Domains\Utils\ValueObjects\WebsiteContent;
use App\Domains\Website\Enums\PageType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Symfony\Component\Yaml\Yaml;

class MarkdownImporter extends Command
{
    const DEFAULT_REPOSITORY_URL = 'https://raw.githubusercontent.com/thegala-dev/tgd-content/main';

    protected $signature = 'markdown:parse {path} {--type=article}';

    protected $description = 'Legge un file Markdown con front matter YAML e ne estrae i dati';

    public function handle(MarkdownParser $markdownService)
    {
        $raw = $this->retrieveContentFromRepo($this->argument('path'));

        if (! preg_match('/^-{3}\s*(.*?)\s*-{3}\s*(.*)/s', $raw, $matches)) {
            $this->error('Front matter non trovato o malformato.');

            return 1;
        }

        $this->info('Sto importando il contenuto');
        $markdownService->parse(
            WebsiteContent::from(Yaml::parse($matches[1]), $matches[2]),
            PageType::from($this->option('type'))
        );

        $this->info('...Fatto! Contenuto importato correttamente');

        return Command::SUCCESS;
    }

    private function retrieveContentFromRepo(string $path): string
    {
        $path = $this->argument('path');
        $url = sprintf('%s/%s', self::DEFAULT_REPOSITORY_URL, $path);

        $response = Http::get($url);

        if ($response->failed()) {
            throw new RuntimeException("❌ Impossibile recuperare il file: {$url}");
        }

        return $response->body();
    }
}
