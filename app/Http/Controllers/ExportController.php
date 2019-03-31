<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class ExportController extends BaseController
{
    public function start(Request $request) {
        $name = bin2hex(random_bytes(5));
        $interval = $request->input('interval');
        $range = $interval != 'all' ? self::dateRange($interval) : false;

        $params = array(
            'name' => $name,
            'interval' => $range,
        );
        return response()
            ->json($params);
    }

    public function export(Request $request, DataExportInterface $data) {
        $name = $request->session()->get('export_name', false);
        $batch = $request->query('batch', false);
        if (!$name) {
            $name = $request->query('name', false);
            if ($batch === false or !$name) {
                abort(403);
            }
        }
        else {
            $request->session()->forget('export_name');
        }
        $interval = $request->query('interval', false);
        $query = $data->getQuery($request, $interval); 
        $max = $query->count(); 
        if ($batch === false) {
            return view('data_export', compact('max', 'name'));
        }
        $filename = "data-exports/{$name}.csv";
        Storage::makeDirectory('data-exports');
        $fcsv = fopen(Storage::path($filename), 'a');
        Storage::setVisibility($filename, 'private');
        
        $batch_size = $data->batchSize();
        $items = $query->offset($batch)->limit($batch_size)->get();
        foreach ($items as $item) {
            $row = $data->makeRow($item);
            fputcsv($fcsv, $row);
            unset($row);
        }

        $url = '';
        $batch += $batch_size;
        if ($batch >= $max) {
            $url = route('export.download', ['name' => $name]);
        }
        $data = compact('batch', 'url', 'name');
        return response()->json($data);
    }

    public function download($name) {
        $filename = "data-exports/{$name}.csv";
        $uri = Storage::path($filename);
        
        /* 
         * Illuminate\Routing\ResponseFactory uses BinaryFileResponse 
         * which doesn't use Illuminate\Http\ResponseTrait
         * but out middleware requires the header method
         */
        $response = new class($uri) extends BinaryFileResponse {
            public function header($key, $values, $replace = true)
            {
                $this->headers->set($key, $values, $replace);
                return $this;
            }
        };

        $response->setContentDisposition('attachment', 'export.csv');
        $response->deleteFileAfterSend(true);
        return $response;
    }



    public static function dateRange($interval) {
        $today = new \DateTime();
        switch($interval) {
            case 'today':
                $range = [$today->format('Y-m-d'), $today->format('Y-m-d')];
                break;
            case 'last_week':
                $today->sub(new \DateInterval('P1W'));
            case 'this_week':
                $week_day = $today->format('w');
                $week_start = clone $today;
                $week_start = $week_start->sub(new \DateInterval("P{$week_day}D"));
                $week_remainder = 6 - (int)$week_day;
                $week_end = clone $today;
                $week_end = $week_end->add(new \DateInterval("P{$week_remainder}D"));
                $range = [$week_start->format('Y-m-d'), $week_end->format('Y-m-d')];
                break;
            case 'last_month':
                $month_days = $today->format('t');
                $today->sub(new \DateInterval("P{$month_days}D"));
            case 'this_month':
                $month_start = new \DateTime($today->format('Y-m-01'));
                $month_end = new \DateTime($today->format('Y-m-t'));
                $range = [$month_start->format('Y-m-d'), $month_end->format('Y-m-d')];
                break;
            default:
                $range = [];
                break;
        }
        return $range;
    }

}
