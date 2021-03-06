<?php

namespace OneStop\Http\Controllers\Cp;

use Illuminate\Http\Request;
use OneStop\Core\Contracts\Repositories\VideoCategoryRepositoryInterface as CategoriesContract;
use OneStop\Core\Support\Traits\FormAjax;
use OneStop\Http\Controllers\Controller;
use OneStop\Http\Controllers\CpController;
use OneStop\Http\Requests\StoreNewVideoCategory;
use OneStop\Http\Requests\UpdateVideoCategory;

class VideoCategoryController extends CpController
{
	use FormAjax;

	/**
	 * Video Category Repository instance.
	 *
	 * @var OneStop\Core\Contracts\Repositories\VideoCategoryRepositoryInterface
	 */
	protected $categories;

	/**
	 * Create new instance of VideoCategory.
	 */
	public function __construct(CategoriesContract $categories,Request $request)
	{
		$this->categories = $categories;
		parent::__construct($request);
	}

	/**
	 * Show the video categories listing page.
	 *
	 * @return view
	 */
	public function index()
	{
		return view('cp.video_categories.index');
	}


	/**
	 * Show the create form of video category.
	 * --------------------------------------
	 * And the if the request is ajax return a data json response for the form.
	 *
	 *
	 * @param  Request $request
	 * @return view|json:data
	 */
	public function create(Request $request)
	{
		if($result = $this->isCreating($request,function($creating){
			return [
				'headerTitle' => 'Create Video Category',
				'category'	  => null,
			];
		})) return $result;

		return view('cp.video_categories.form');
	}

	/**
	 * [store description]
	 * @param  StoreNewVideoCategory $request [description]
	 * @return [type]                         [description]
	 */
	public function store(StoreNewVideoCategory $request)
	{
		$this->categories->create($request);

		session()->flash('success','Video Category has been successfully created.');

		return response()->json([
			'path'	=> route('cp.videos.categories.index')
		]);
	}


	/**
	 * Show the Edit Form.
 *
	 * @param  Request $request
	 * @param  [type]  $slug
	 * @return view|json:data
	 */
	public function edit(Request $request,$slug)
	{
		if($result = $this->isEditing($request,function($editing) use ($slug) {

			$category = $this->categories->getBySlug($slug);

			return [
				'headerTitle' 	=> 'Edit ' . $category->name,
				'category'		=> $category
			];

		})) return $result;

		return view('cp.video_categories.form');
	}


	public function update($category,UpdateVideoCategory $request)
	{


		$this->categories->update($category,$request);

		session()->flash('success','Video Category has been successfully updated.');

		return response()->json([
			'path'	=> route('cp.videos.categories.index')
		]);

	}

	/**
	 *
	 * @return [type] [description]
	 */
	public function get()
	{
		$categories = $this->categories->getAll()->supplement('checked',function(){
			return false;
		});

		$data = [
			'columns' 	=> ['name','description'],
			'items'		=> $categories
		];

		return $data;
	}


	/**
	 * Delete a categories by a given ids.
	 *
	 * @return
	 */
	public function delete()
	{
		$ids = $this->request->get('ids');

		if(count($ids)){
		$this->categories->delete($ids);
			return response()->json([
				'success'	=> true,
				'message'	=> 'The category was successfully deleted.'
			]);
		}

		return response()->json([
				'success'	=> false,
				'message'	=> 'There was an error deleting the category.'
		],400);
	}
}
