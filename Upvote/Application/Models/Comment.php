<?php
namespace Upvote\Application\Models;
use Upvote\Application\Models\Interfaces\SimpleModel;
use Upvote\Application\Models\Interfaces\ModelValidation;
class Comment extends BaseModel implements SimpleModel, ModelValidation
{
	
	/**
	 * Comment ID
	 * @var int
	 */
	protected $id;
	
	/**
	 * Created By (User) id
	 * @var int
	 */
	protected $created_by;
	
	/**
	 * Date Created.
	 * @var \DateTime
	 */
	protected $created_on;
	
	/**
	 * Story id
	 * @var int
	 */
	protected $story_id;
	
	/**
	 * Comment
	 * @var string
	 */
	protected $comment;
	
	/**
	 * Is the model valid or not.
	 * 
	 * @var bool
	 */
	protected $is_valid = false;
	
	/**
	 * Name of the database table.
	 * 
	 * @var string
	 */
	protected $tableName = 'comment';
	

	/**
	 * Converts model object to an array.
	 * 
	 * @return multitype
	 */
	public function toArray()
	{
		$data = array();
		$data['id'] = $this->id;
		$data['created_on'] = $this->created_on->format('Y-m-d H:i:s');
		$data['created_by'] = $this->created_by;
		$data['story_id'] = $this->story_id;
		$data['comment'] = $this->comment;
		return $data;
	}
	
	/**
	 * Validates the model
	 *
	 * @see \Upvote\Application\Models\Interfaces\SimpleModel::validate()
	 */
	public function validate() 
	{
		throw new ModelException(__METHOD__ . ' is not yet implemented.');
	}
	
	/* (non-PHPdoc)
	 * @see \Upvote\Application\Models\Interfaces\SimpleModel::isValid()
	*/
	public function isValid()
	{
		return $this->is_valid;
	}
	
	/* (non-PHPdoc)
	 * @see \Upvote\Application\Models\Interfaces\ModelValidation::addFilter()
	*/
	public function addFilter() 
	{
		throw new ModelException(__METHOD__ . ' is not yet implemented.');
	}
	
	/* (non-PHPdoc)
	 * @see \Upvote\Application\Models\Interfaces\ModelValidation::addValidator()
	*/
	public function addValidator() 
	{
		throw new ModelException(__METHOD__ . ' is not yet implemented.');
	}
	
	/* (non-PHPdoc)
	 * @see \Upvote\Application\Models\Interfaces\ModelValidation::filter()
	*/
	public function filter() 
	{
		throw new ModelException(__METHOD__ . ' is not yet implemented.');
	}
	
	/* (non-PHPdoc)
	 * @see \Upvote\Application\Models\Interfaces\ModelValidation::getFilter()
	*/
	public function getFilter() 
	{
		throw new ModelException(__METHOD__ . ' is not yet implemented.');
	}
	
	/* (non-PHPdoc)
	 * @see \Upvote\Application\Models\Interfaces\ModelValidation::getValidator()
	*/
	public function getValidator() 
	{
		throw new ModelException(__METHOD__ . ' is not yet implemented.');
	}
}