<?php

namespace Upvote\Application\Models\Interfaces;

interface SimpleModel 
{
	public function populate(array $data);
	public function save();
}