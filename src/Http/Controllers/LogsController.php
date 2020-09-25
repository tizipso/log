<?php

namespace Dcat\Admin\Extension\Logs\Http\Controllers;

use Dcat\Admin\Extension\Logs\Logs;
use Dcat\Admin\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LogsController extends Controller
{
    public function index(Content $content, $file = null, Request $request)
    {
        if ($file === null) {
            $file = (new Logs())->getLastModifiedLog();
        }

        $viewer = new Logs($file);

        // dd($viewer->getNextPageUrl());

        $offset = $request->get('offset');

        return $content
            ->title($viewer->getFilePath())
            ->body(view('logs::index', [
            'logs'      => $viewer->fetch($offset),
            'logFiles'  => $viewer->getLogFiles(),
            'fileName'  => $viewer->file,
            'end'       => $viewer->getFilesize(),
            'tailPath'  => route('log-viewer-tail', ['file' => $viewer->file]),
            'prevUrl'   => $viewer->getPrevPageUrl(),
            'nextUrl'   => $viewer->getNextPageUrl(),
            'filePath'  => $viewer->getFilePath(),
            'size'      => static::bytesToHuman($viewer->getFilesize()),
            ]));
    }

    public function tail($file, Request $request)
    {
        $offset = $request->get('offset');

        $viewer = new Logs($file);

        list($pos, $logs) = $viewer->tail($offset);

        return compact('pos', 'logs');
    }

    protected static function bytesToHuman($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2).' '.$units[$i];
    }
}
