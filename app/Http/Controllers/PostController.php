<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;


class PostController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		return response()->json([
			'status' => 'success',
			'data' => Post::all()
		], 200);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StorePostRequest $request)
	{
		try {
			$post = Post::create($request->validated()); // returns validated data from StorePostRequest
			return response()->json([
				'status' => 'success',
				'message' => 'Post created successfully.',
			], 201);
		} catch (\Exception $e) {
			return response()->json([
				'status' => 'error',
				'message' => 'An error occurred while creating the post.',
				'error' => $e->getMessage()
			], 500);
		}
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Post $post)
	{
		return response()->json([
			'status' => 'success',
			'data' => $post->content
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdatePostRequest $request, Post $post)
	{
		try {
			$post->update($request->validated());
			return response()->json([
				'status' => 'success',
				'message' => 'Post updated successfully.',
			], 200);
		} catch (\Exception $e) {
			return response()->json([
				'status' => 'error',
				'message' => 'An error occurred while updating the post.',
				'error' => $e->getMessage()
			], 500);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Post $post) 
	{
		$post->delete();
		return response()->json([
			'message' => 'Post deleted successfully.'
		], 200);
	
	}
}