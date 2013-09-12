<?php

namespace Upvote\Application\Models\Interfaces;

interface ModelValidation 
{
	
	public function addValidator();
	public function addFilter();
	public function getValidator();
	public function getFilter();
	public function validate();
	public function filter();
	public function isValid();
}