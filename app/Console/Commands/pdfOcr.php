<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class pdfOcr extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:pdf-ocr {file_path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $file_path = $this->argument('file_path');

        $pdfTpath = env('APP_ENV') == 'pc' ? '/opt/homebrew/bin/pdftotext' : '/usr/bin/pdftotext';
        $inputPdfPath = (string) $file_path;

        $outputOcrPdfPath = (string) $file_path;
        $ocrmypdfPath = 'ocrmypdf'; // replace with the actual path to ocrmypdf
        $language = 'eng';

       // $process = new Process([$ocrmypdfPath." ".$inputPdfPath." ".$outputOcrPdfPath]);
        $process = \Illuminate\Support\Facades\Process::start($ocrmypdfPath." ".$inputPdfPath." ".$outputOcrPdfPath, function (string $type, string $output) {
            echo $output;
        });
        $result = $process->wait();

    }
}
