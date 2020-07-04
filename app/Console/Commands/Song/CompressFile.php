<?php

namespace App\Console\Commands\Song;

use Illuminate\Console\Command;

/**
 * Class CompressFile
 *
 * @package App\Console\Commands\Song
 */
class CompressFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'song:convert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compress and convert file to mp3.';
    /**
     * @var string
     */
    protected $fileName;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = __DIR__.DIRECTORY_SEPARATOR.config('paths.stbl');
        exec(
            'ffmpeg -i ' . $path . DIRECTORY_SEPARATOR . $this->fileName .
            '.mpga -acodec libmp3lame -ab 64k -ac 1 -ar 11025 ' . $path .
            DIRECTORY_SEPARATOR . $this->fileName . '.mp3;'
        );
    }
}
