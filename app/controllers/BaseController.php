<?php

class BaseController extends Controller {

    public $pageSize = '20';
    protected $layout = 'layout.layout';
	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}

	}

    public function __construct()
    {
        $pageSize = Config::get('app.pageSize');
        if($pageSize)
        {
            $this->pageSize = $pageSize;
        }

    }

}
