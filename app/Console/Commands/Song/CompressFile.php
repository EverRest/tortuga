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
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        chdir('/');
        exec(
            'cd storage/app/public/music&&ffmpeg -i 9ETO6KZ6tN_1593867302.mpga -acodec libmp3lame -ab 64k -ac 1 -ar 11025 ' . $path .
            DIRECTORY_SEPARATOR . '9ETO6KZ6tN_1593867302' . '.mp3;'
        );
    }
}
