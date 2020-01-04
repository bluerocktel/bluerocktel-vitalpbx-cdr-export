<?php

namespace App\Console\Commands;

use App\BlueRock\ThirdParty\VitalPBX\Export;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class BlueRockTELProduceVitalPbxCdrCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'brtel:produceVitalPbxCdr {start} {end}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Produce cdr file';

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
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $start = $this->argument('start');

        $end = $this->argument('end');

        if (config('bluerocktel.pbxId')) {

            $this->info('configuration ok');

            sleep(rand(0, 120));

            try {

                $export = new Export($start, $end);

                $filename = $export->run();

                $content = Storage::disk('local')->get('/tmp/' . $filename);

                Storage::disk('ftp')->makeDirectory('cdr/vitalpbx');

                Storage::disk('ftp')->put('cdr/vitalpbx/' . $filename, $content);

                $this->info($filename . ' has been stored on the ftp server.');

                Storage::disk('local')->delete('/tmp/' . $filename);

            } catch (\Exception $exception) {

                print $exception->getMessage() . PHP_EOL;

            }

        } else {

            $this->warn('You must set a value for pbxId in .env file.');

        }

        return;

    }
}
