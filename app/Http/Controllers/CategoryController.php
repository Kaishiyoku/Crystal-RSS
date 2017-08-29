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
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }

        $category = new Category($request->only(['title']));

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
        $validator = $this->validator($request->all(), $category->id);

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }

        $category->fill($request->only(['title']));
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
        /*if ($category->notes()->count() > 0) {
            flash()->error(trans('section.destroy.notes_exist'));

            return redirect()->route('sections.edit', [$section->getIdAndSlug()]);
        } else {*/
            $category->delete();

            flash()->success(trans('category.destroy.success'));

            return redirect()->route($this->redirectRoute);
        //}
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
        return Validator::make($data, $this->getValidationRulesWithTitleUniqueness($id));
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
