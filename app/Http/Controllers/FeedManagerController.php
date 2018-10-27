<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
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
        $categories = $this->getCategories();

        return view('feed_manager.create', compact('feed', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->getValidationRules());

        // discover feed
        try {
            $reader = new Reader();
            $resource = $reader->discover($data['site_or_feed_url']);
            $parser = $reader->getParser($resource->getUrl(), $resource->getContent(), $resource->getEncoding());
            $rssFeed = $parser->execute();

            $feed = new Feed();
            $feed->site_url = $rssFeed->getSiteUrl();
            $feed->feed_url = $rssFeed->getFeedUrl();
            $feed->title = $rssFeed->getTitle();
            $feed->category_id = $data['category_id'];

            auth()->user()->feeds()->save($feed);

            flash()->success(trans('feed_manager.create.success', ['url' => route('feed.manage.create')]));

            return redirect()->route('feed.manage.edit', [$feed->id]);
        } catch (PicoFeedException $e) {
            $validator = Validator::make([], []);
            $validator->getMessageBag()->add('site_or_feed_url', trans('feed_manager.feed_exception'));

            throw new ValidationException($validator);
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
        $categories = $this->getCategories();

        return view('feed_manager.edit', compact('feed', 'categories'));
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

        $data = $request->validate($this->getValidationRules($feed->id));

        // check feed
        try {
            $reader = new Reader();
            $resource = $reader->download($data['feed_url']);
            $reader->getParser($resource->getUrl(), $resource->getContent(), $resource->getEncoding());

            $feed->save();
            $feed->title = $data['title'];
            $feed->feed_url = $data['feed_url'];
            $feed->site_url = $data['site_url'];
            $feed->category_id = $data['category_id'];

            $feed->save();

            flash()->success(trans('feed_manager.edit.success'));

            return redirect()->route($this->redirectRoute);
        }
        catch (PicoFeedException $e) {
            $validator = Validator::make([], []);
            $validator->getMessageBag()->add('feed_url', trans('feed_manager.feed_exception'));

            throw new ValidationException($validator);
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

        $feed->feedItems()->delete();
        $feed->updateErrors()->delete();

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
            'site_or_feed_url' => ['sometimes', 'max:191'],
            'title' => ['sometimes', 'max:191'],
            'site_url' => ['sometimes', 'url', 'max:191'],
            'feed_url' => [
                'sometimes',
                'url',
                'max:191',
                Rule::unique('feeds')->ignore($id)->where(function ($query) {
                    $query->where('user_id', auth()->user()->id);
                })
            ],
            'category_id' => [
                Rule::in($this->getCategories()->keys()->all()),
            ]
        ];
    }

    private function getCategories()
    {
        return auth()->user()->categories()->pluck('title', 'id');
    }
}
