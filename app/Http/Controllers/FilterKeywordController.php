<?php

namespace App\Http\Controllers;

use App\Models\FilterKeyword;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FilterKeywordController extends Controller
{
    /**
     * @var array
     */
    private $validationRules = [
        'value' => ['required', 'max:191'],
    ];

    /**
     * @var string
     */
    private $redirectRoute = 'filter_keywords.index';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $filterKeywords = auth()->user()->filterKeywords();

        return view('filter_keyword.index', compact('filterKeywords'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $filterKeyword = new FilterKeyword();

        return view('filter_keyword.create', compact('filterKeyword'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->getValidationRules());

        $filterKeyword = new FilterKeyword($data);

        auth()->user()->filterKeywords()->save($filterKeyword);

        markFeedItemsAsHiddenByKeywords(auth()->user());

        flash()->success(__('filter_keyword.create.success'));

        return redirect()->route($this->redirectRoute);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FilterKeyword  $filterKeyword
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(FilterKeyword $filterKeyword)
    {
        $this->authorize('delete', $filterKeyword);

        $filterKeyword->delete();

        return redirect()->route($this->redirectRoute);
    }

    /**
     * @return array
     */
    protected function getValidationRules()
    {
        $valueUniquessRule = Rule::unique('filter_keywords', 'value')->where('user_id', auth()->user()->id);

        $validationRules = $this->validationRules;
        $validationRules['value'][] = $valueUniquessRule;

        return $validationRules;
    }
}
