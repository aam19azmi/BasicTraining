<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use App\Http\Requests\StoreRepositoryRequest;
use App\Http\Requests\UpdateRepositoryRequest;
use App\Models\Category;

class RepositoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $repositories = Repository::with('category')->get();
        return view('repositories.index', compact('repositories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all()
                    ->sortByDesc('created_at');
        return view('repositories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRepositoryRequest $request)
    {
        $repository = new Repository();
        $repository->name = $request->name;
        $repository->description = $request->description;
        $repository->category_id = $request->category_id;
        $repository->save();

        return redirect()->route('repositories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Repository $repository)
    {
        return view('repositories.show', compact('repository'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Repository $repository)
    {
        $categories = Category::all()
                    ->sortByDesc('created_at');
        return view('repositories.edit', compact('repository', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRepositoryRequest $request, Repository $repository)
    {
        $repository->update($request->validated());

        return redirect()->route('repositories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Repository $repository)
    {
        $repository->delete();

        return redirect()->route('repositories.index');
    }
}