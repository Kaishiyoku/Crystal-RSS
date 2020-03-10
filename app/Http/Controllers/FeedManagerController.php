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
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $feeds = auth()->user()->feeds()->with('category')->orderBy('title');

        return view('feed_manager.index', compact('feeds'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function archived()
    {
        $feeds = auth()->user()->feeds()->onlyTrashed()->with('category')->orderBy('title');

        return view('feed_manager.archived', compact('feeds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
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
     * @return \Illuminate\Http\RedirectResponse
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
        $feed->feed_url = $rssFeed->getFeedUrl() ?? $data['feed_url'];
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
     * @param Feed $feed
     * @return \Illuminate\View\View
     */
    public function edit(Feed $feed)
    {
        $this->authorize('update', $feed);

        $categories = $this->getCategories();

        return view('feed_manager.edit', compact('feed', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Feed $feed
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Feed $feed)
    {
        $this->authorize('update', $feed);

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
     * @param Feed $feed
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Feed $feed)
    {
        $this->authorize('delete', $feed);

        $feed->delete();

        flash()->success(__('feed_manager.destroy.success'));

        return redirect()->route($this->redirectRoute);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroyPermanently(int $id)
    {
        $feed = Feed::withTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $feed);

        $feed->feedItems()->delete();
        $feed->updateErrors()->delete();

        $feed->forceDelete();

        flash()->success(__('feed_manager.destroy_permanently.success'));

        return redirect()->route($this->redirectRoute);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param int $íd
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function restore(int $id)
    {
        $feed = Feed::withTrashed()->findOrFail($id);

        $this->authorize('restore', $feed);

        $feed->restore();

        flash()->success(__('feed_manager.restore.success'));

        return redirect()->route($this->redirectRoute);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
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
