<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Kaishiyoku\HeraRssCrawler\HeraRssCrawler;

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
        $feeds = auth()->user()->feeds()->with('category')->orderBy('title');

        return view('feed_manager.index', compact('feeds'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function archived()
    {
        $feeds = auth()->user()->feeds()->onlyTrashed()->with('category')->orderBy('title');

        return view('feed_manager.archived', compact('feeds'));
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

        // check feed
        $heraRssCrawler = new HeraRssCrawler();
        $feedIsConsumable = $heraRssCrawler->checkIfConsumableFeed($data['feed_url']);

        if (!$feedIsConsumable) {
            $validator = Validator::make([], []);
            $validator->getMessageBag()->add('feed_url', __('feed_manager.feed_exception'));

            throw new ValidationException($validator);
        }

        $rssFeed = $heraRssCrawler->parseFeed($data['feed_url']);

        $feed = new Feed();
        $feed->site_url = $data['site_url'];
        $feed->feed_url = $rssFeed->getFeedUrl();
        $feed->title = $rssFeed->getTitle();
        $feed->color = $data['color'];
        $feed->category_id = $data['category_id'];

        auth()->user()->feeds()->save($feed);

        flash()->success(__('feed_manager.create.success', ['url' => route('feed.manage.create')]));

        return redirect()->route('feed.manage.edit', [$feed->id]);
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

        $feed->title = $data['title'];
        $feed->feed_url = $data['feed_url'];
        $feed->site_url = $data['site_url'];
        $feed->color = $data['color'];
        $feed->category_id = $data['category_id'];
        $feed->is_enabled = $data['is_enabled'];

        $feed->save();

        flash()->success(__('feed_manager.edit.success'));

        return redirect()->route($this->redirectRoute);
    }

    /**
     * Remove the specified resource from storage.
     * They are only archived, not fully removed.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $feed = auth()->user()->feeds()->findOrFail($id);

        //$feed->feedItems()->delete();
        //$feed->updateErrors()->delete();

        $feed->delete();

        flash()->success(__('feed_manager.destroy.success'));

        return redirect()->route($this->redirectRoute);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyPermanently($id)
    {
        $feed = auth()->user()->feeds()->onlyTrashed()->findOrFail($id);

        $feed->feedItems()->delete();
        $feed->updateErrors()->delete();

        $feed->forceDelete();

        flash()->success(__('feed_manager.destroy_permanently.success'));

        return redirect()->route($this->redirectRoute);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $feed = auth()->user()->feeds()->onlyTrashed()->findOrFail($id);

        $feed->restore();

        flash()->success(__('feed_manager.restore.success'));

        return redirect()->route($this->redirectRoute);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function discover(Request $request)
    {
        $heraRssCrawler = new HeraRssCrawler();
        $feedUrls = $heraRssCrawler->discoverFeedUrls($request->get('url'));

        return response()->json($feedUrls);
    }

    /**
     * @return array
     */
    private function getValidationRules($id = null)
    {
        return [
            'title' => ['sometimes', 'max:191'],
            'site_url' => ['required', 'url', 'max:191'],
            'feed_url' => [
                'required',
                'url',
                'max:191',
                Rule::unique('feeds')->ignore($id)->where(function ($query) {
                    $query->where('user_id', auth()->user()->id);
                })
            ],
            'category_id' => [
                Rule::in($this->getCategories()->keys()->all()),
            ],
            'is_enabled' => [
                'sometimes',
                'boolean',
            ],
            'color' => ['nullable', 'color_hex']
        ];
    }

    private function getCategories()
    {
        return auth()->user()->categories()->pluck('title', 'id');
    }
}
