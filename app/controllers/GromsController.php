<?php

class GromsController extends \BaseController {

	function __construct(Grom $grom) {
		$this->grom = $grom;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// total
		// per_page
		// current_page
		// last_page
		// from
		// to
		// groms
		$results = array('groms' => $this->grom->orderBy('id', 'desc')->paginate(15)->toArray());
		return Response::json($results)
			->setCallback(Input::get('callback'));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function user(User $user)
	{
		// total
		// per_page
		// current_page
		// last_page
		// from
		// to
		// groms
		$results = array('user' => $user->toArray(), 'groms' => $this->grom->orderBy('id', 'desc')->paginate(15)->toArray());
		return Response::json($results)
			->setCallback(Input::get('callback'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if(Input::hasFile('content')) {
			$file = Input::file('content');
			$description = Input::get('description', '');
			$grom = $this->grom->moveAndSave($file, array(
				'content_type' => 'image',
				'user_id'      => Auth::user()->id,
				'description'  => $description
				));
			return $grom->toJson();
		}

		return Response::json(array('error' => 'Invalid data'))->setCallback(Input::get('callback'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function image(Grom $grom)
	{
		return Redirect::to(URL::to($grom->public_path));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}