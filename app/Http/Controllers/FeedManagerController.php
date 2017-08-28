<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PicoFeed\PicoFeedException;
use PicoFeed\Reader\Reader;

class FeedManagerController extends Controller
{
    /**
     * @var string
     */
    private $redirectRoute = 'feed.manage.index';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feeds = auth()->user()->feeds()->orderBy('title');

        return view('feed_manager.index', compact('feeds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $feed = new Feed();

        return view('feed_manager.create', compact('feed'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }

        // discover feed
        try {
            $reader = new Reader();
            $resource = $reader->discover($request->get('site_or_feed_url'));
            $parser = $reader->getParser($resource->getUrl(), $resource->getContent(), $resource->getEncoding());
            $rssFeed = $parser->execute();

            $feed = new Feed();
            $feed->site_url = $rssFeed->getSiteUrl();
            $feed->feed_url = $rssFeed->getFeedUrl();
            $feed->title = $rssFeed->getTitle();

            auth()->user()->feeds()->save($feed);

            flash()->success(trans('feed_manager.create.success'));

            return redirect()->route($this->redirectRoute);
        } catch (PicoFeedException $e) {
            $validator->getMessageBag()->add('site_or_feed_url', trans('feed_manager.feed_exception'));

            $this->throwValidationException($request, $validator);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $feed = auth()->user()->feeds()->findOrFail($id);

        return view('feed_manager.edit', compact('feed'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $feed = auth()->user()->feeds()->findOrFail($id);

        $validator = $this->validator($request->all(), $feed->id);

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }

        // check feed
        try {
            $reader = new Reader();
            $resource = $reader->download($request->get('feed_url'));
            $reader->getParser($resource->getUrl(), $resource->getContent(), $resource->getEncoding());

            $feed->save();
            $feed->title = $request->get('title');
            $feed->feed_url = $request->get('feed_url');
            $feed->site_url = $request->get('site_url');

            $feed->save();

            flash()->success(trans('feed_manager.edit.success'));

            return redirect()->route($this->redirectRoute);
        }
        catch (PicoFeedException $e) {
            $validator->getMessageBag()->add('feed_url', trans('feed_manager.feed_exception'));

            $this->throwValidationException($request, $validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $feed = auth()->user()->feeds()->findOrFail($id);

        $feed->delete();

        flash()->success(trans('feed_manager.destroy.success'));

        return redirect()->route($this->redirectRoute);
    }

    /**
     * @return array
     */
    private function getValidationRules($id = null)
    {
        return [
            'title' => ['sometimes', 'max:191'],
            'site_url' => ['sometimes', 'url', 'max:191'],
            'feed_url' => ['sometimes', 'url', 'max:191', Rule::unique('feeds')->ignore($id)->where(function ($query) {
                $query->where('user_id', auth()->user()->id);
            })]
        ];
    }

    /**
     * Get a validator for an incoming request.
     *
     * @param  array $data
     * @param  int $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, $id = null)
    {
        return Validator::make($data, $this->getValidationRules($id));
    }

}
