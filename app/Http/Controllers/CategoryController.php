<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * @var array
     */
    private $validationRules = [
        'title' => ['required', 'max:191']
    ];

    /**
     * @var string
     */
    private $redirectRoute = 'categories.index';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = auth()->user()->categories();

        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new Category();

        return view('category.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->getValidationRulesWithTitleUniqueness());

        $category = new Category($data);

        auth()->user()->categories()->save($category);

        flash()->success(trans('category.create.success'));

        return redirect()->route($this->redirectRoute);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->validate($this->getValidationRulesWithTitleUniqueness($category->id));

        $category->fill($data);
        $category->save();

        flash()->success(trans('category.edit.success'));

        return redirect()->route($this->redirectRoute);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category->feeds()->count() > 0) {
            flash()->error(trans('category.destroy.feeds_exist'));
        } else {
            $category->delete();

            flash()->success(trans('category.destroy.success'));
        }

        return redirect()->route($this->redirectRoute);
    }

    /**
     * @param null $id
     * @return array
     */
    protected function getValidationRulesWithTitleUniqueness($id = null)
    {
        $titleUniquessRule = Rule::unique('categories', 'title')->where('user_id', auth()->user()->id);

        if ($id != null) {
            $titleUniquessRule = $titleUniquessRule->ignore($id);
        }

        $validationRules = $this->validationRules;
        $validationRules['title'][] = $titleUniquessRule;

        return $validationRules;
    }
}
