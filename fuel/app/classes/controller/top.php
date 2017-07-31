<?php
class Controller_Top extends Controller_Template
{
    /**
     * A typical "Hello, Bob!" type example.  This uses a Presenter to
     * show how to use them.
     *
     * @access  public
     * @return  Response
     */
    public function action_index()
    {
        $this->template->content = View::forge('top/index');
    }
}
