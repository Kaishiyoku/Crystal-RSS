<?php

namespace App\Http\Controllers;

use App\Models\UpdateError;

class UpdateErrorController extends Controller
{
    /**
     * @var string
     */
    private $redirectRoute = 'update_errors.index';

    public function index()
    {
        $totalNumberOfUpdateErrors = auth()->user()->updateErrors->count();
        $updateErrors = auth()->user()->updateErrors()->with('feed')->orderBy('created_at', 'desc')->paginate();

        return view('update_error.index', compact('totalNumberOfUpdateErrors', 'updateErrors'));
    }

    public function show(UpdateError $updateError)
    {
        $this->authorize('view', $updateError);

        return view('update_error.show', compact('updateError'));
    }

    public function clear()
    {
        auth()->user()->updateErrors()->delete();

        flash()->success(__('update_error.clear.success'));

        return redirect()->route($this->redirectRoute);
    }
}
