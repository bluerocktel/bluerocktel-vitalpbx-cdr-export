<?php

namespace App\BlueRock\ThirdParty\VitalPBX;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use League\Csv\Writer;

class Export
{
    private $start;

    private $end;

    public function __construct($start, $end)
    {
        $this->start = $start;

        $this->end = $end;
    }

    public function run()
    {
        $start = $this->start;

        $end = $this->end;

        $start = Carbon::createFromFormat('Y-m-d', $start);
        $start->startOfDay();

        $end = Carbon::createFromFormat('Y-m-d', $end);
        $end->endOfDay();

        $pbxId = config('bluerocktel.pbxId');

        $filename = 'vitalPbx' . '_' . $pbxId . '_' . $start->format('Ymd') . '_' . $end->format('Ymd') . '.csv';

        Storage::disk('local')->makeDirectory('tmp');

        $cdr = Writer::createFromPath(storage_path('app/tmp/' . $filename), 'w');

        $cdr->insertOne([

            'cdr_id',
            'calldate',
            'clid',
            'source',
            'src',
            'dst',
            'destination',
            'dcontext',
            'channel',
            'dstchannel',
            'lastapp',
            'lastdata',
            'duration',
            'billsec',
            'disposition',
            'amaflags',
            'uniqueid',
            'linkedid',
            'sequence',
            'calltype',

        ]);

        DB::connection('mysql')
            ->table('cdr')
            ->where('calldate', '>=', $start)
            ->where('calldate', '<=', $end)
            ->orderBy('calldate')
            ->chunk(100, function ($calls) use (&$cdr) {

                foreach ($calls as $call) {

                    $calldate = new Carbon($call->calldate);
                    $calldate = $calldate->format('Y-m-d H:i:s'); // TODO : could be removed, I left it in order to match current ombutel cdr

                    $cdr->insertOne([

                        $call->cdr_id,
                        $calldate,
                        $call->clid,
                        $call->source,
                        $call->src,
                        $call->dst,
                        $call->destination,
                        $call->dcontext,
                        $call->channel,
                        $call->dstchannel,
                        $call->lastapp,
                        $call->lastdata,
                        $call->duration,
                        $call->billsec,
                        $call->disposition,
                        $call->amaflags,
                        $call->uniqueid,
                        $call->linkedid,
                        $call->sequence,
                        $call->calltype,

                    ]);

                }

            });

        return $filename;

    }

}