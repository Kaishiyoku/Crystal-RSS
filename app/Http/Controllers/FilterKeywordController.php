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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filterKeywords = auth()->user()->filterKeywords();

        return view('filter_keyword.index', compact('filterKeywords'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->getValidationRulesWithValueUniqueness());

        $filterKeyword = new FilterKeyword($data);

        auth()->user()->filterKeywords()->save($filterKeyword);

        flash()->success(__('filter_keyword.create.success'));

        return redirect()->route($this->redirectRoute);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FilterKeyword  $filterKeyword
     * @return \Illuminate\Http\Response
     */
    public function edit(FilterKeyword $filterKeyword)
    {
        $this->authorize('update', $filterKeyword);

        return view('filter_keyword.edit', compact('filterKeyword'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FilterKeyword  $filterKeyword
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FilterKeyword $filterKeyword)
    {
        $this->authorize('update', $filterKeyword);

        $data = $request->validate($this->getValidationRulesWithValueUniqueness($filterKeyword->id));

        $filterKeyword->fill($data);
        $filterKeyword->save();

        flash()->success(__('filter_keyword.edit.success'));

        return redirect()->route($this->redirectRoute);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FilterKeyword  $filterKeyword
     * @return \Illuminate\Http\Response
     */
    public function destroy(FilterKeyword $filterKeyword)
    {
        $this->authorize('delete', $filterKeyword);

        $filterKeyword->delete();

        return redirect()->route($this->redirectRoute);
    }

    /**
     * @param int|null $id
     * @return array
     */
    protected function getValidationRulesWithValueUniqueness($id = null)
    {
        $valueUniquessRule = Rule::unique('filter_keywords', 'value')->where('user_id', auth()->user()->id);

        if ($id != null) {
            $valueUniquessRule = $valueUniquessRule->ignore($id);
        }

        $validationRules = $this->validationRules;
        $validationRules['value'][] = $valueUniquessRule;

        return $validationRules;
    }
}
