<?php

namespace App\Http\Controllers;

use PicoFeed\PicoFeedException;
use PicoFeed\Reader\Reader;
use Vinelab\Rss\Rss;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*try {

            $reader = new Reader;
            $resource = $reader->discover('https://alistapart.com/');

            $parser = $reader->getParser(
                $resource->getUrl(),
                $resource->getContent(),
                $resource->getEncoding()
            );

            $feed = $parser->execute();
            dd($feed);
        }
        catch (PicoFeedException $e) {
        }*/

        return view('home.index');
    }
}