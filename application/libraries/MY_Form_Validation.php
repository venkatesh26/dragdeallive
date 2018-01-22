<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class MY_Form_validation extends CI_Form_validation {
	
	
	private $json = array();
	private $opts = array();
	
	public function __construct()
	{
		parent::__construct();
	}
	public function clear_validation() {
        $this->_field_data = array();
		$this->_error_array = array();
        return $this;
    }
	public function get_error_array(){
		return $this->_error_array;
	}
	
	function set_rules($field, $label = '', $rules = '')
	{
		if (count($_POST) === 0 AND count($_FILES) > 0) //it will prevent the form_validation from working
		{
			//add a dummy $_POST
			$_POST['DUMMY_ITEM'] = '';
			parent::set_rules($field,$label,$rules);
			unset($_POST['DUMMY_ITEM']);
		}
		else
		{
			//we are safe just run as is
			parent::set_rules($field,$label,$rules);
		}	
	}
	
	public function run($group='')
	{
		$rc = FALSE;
		log_message('DEBUG','called MY_form_validation:run()');
		if(count($_POST)===0 AND count($_FILES)>0)//does it have a file only form?
		{
			//add a dummy $_POST
			$_POST['DUMMY_ITEM'] = '';
			$rc = parent::run($group);
			unset($_POST['DUMMY_ITEM']);
		}
		else
		{
			//we are safe just run as is
			$rc = parent::run($group);
		}
		
		return $rc;
	}

	function file_upload_error_message($error_code)
	{
		switch ($error_code)
		{
			case UPLOAD_ERR_INI_SIZE:
				return $this->CI->lang->line('error_max_filesize_phpini');
			case UPLOAD_ERR_FORM_SIZE:
				return $this->CI->lang->line('error_max_filesize_form');
			case UPLOAD_ERR_PARTIAL:
				return $this->CI->lang->line('error_partial_upload');
			case UPLOAD_ERR_NO_FILE:
				return $this->CI->lang->line('error_partial_upload');
			case UPLOAD_ERR_NO_TMP_DIR:
				return $this->CI->lang->line('error_temp_dir');
			case UPLOAD_ERR_CANT_WRITE:
				return $this->CI->lang->line('error_disk_write');
			case UPLOAD_ERR_EXTENSION:
				return $this->CI->lang->line('error_stopped');
			default:
				return $this->CI->lang->line('error_unexpected').$error_code;
		}
	}	 
	
	function _execute($row, $rules, $postdata = NULL, $cycles = 0)
	{
		log_message('DEBUG','called MY_form_validation::_execute ' . $row['field']);
		//changed based on
		//http://codeigniter.com/forums/viewthread/123816/P10/#619868
		if(isset($_FILES[$row['field']]) OR in_array('file_required', $rules))
		{// it is a file so process as a file
			log_message('DEBUG','processing as a file');
			if(isset($_FILES[$row['field']])) $postdata = $_FILES[$row['field']];
			else {
				$postdata = array('error' => UPLOAD_ERR_OK, 'size' => 0);
			}

			//before doing anything check for errors
		  if($postdata['error'] !== UPLOAD_ERR_OK)
			{
				//If the error it's 4 (ERR_NO_FILE) and the file required it's deactivated don't call an error
				if($postdata['error'] != UPLOAD_ERR_NO_FILE)
				{
					  $this->_error_array[$row['field']] = $this->file_upload_error_message($postdata['error']);
					  return FALSE;
				}

				// Own code
				/*elseif($postdata['error'] == UPLOAD_ERR_NO_FILE and in_array('file_required', $rules))
				{
					  $this->_error_array[$row['field']] = $this->file_upload_error_message($postdata['error']);
					  return FALSE;
				}*/
			}
			
			$_in_array = FALSE;		
		
			// If the field is blank, but NOT required, no further tests are necessary
			$callback = FALSE;
			if ( ! in_array('file_required', $rules) AND $postdata['size']==0)
			{
				// Before we bail out, does the rule contain a callback?
				if (preg_match("/(callback_\w+)/", implode(' ', $rules), $match))
				{
					$callback = TRUE;
					$rules = (array('1' => $match[1]));
				}
				else
				{
					return;
				}
			}		
			
			foreach($rules as $rule)
			{
				/// COPIED FROM the original class
				
				// Is the rule a callback?			
				$callback = FALSE;
				if (substr($rule, 0, 9) == 'callback_')
				{
					$rule = substr($rule, 9);
					$callback = TRUE;
				}
				
				// Strip the parameter (if exists) from the rule
				// Rules can contain a parameter: max_length[5]
				$param = FALSE;
				if (preg_match("/(.*?)\[(.*?)\]/", $rule, $match))
				{
					$rule	= $match[1];
					$param	= $match[2];
				}			
				
				// Call the function that corresponds to the rule
				if ($callback === TRUE)
				{
					if ( ! method_exists($this->CI, $rule))
					{		 
						continue;
					}
					
					// Run the function and grab the result
					$result = $this->CI->$rule($postdata, $param);

					// Re-assign the result to the master data array
					if ($_in_array == TRUE)
					{
						$this->_field_data[$row['field']]['postdata'][$cycles] = (is_bool($result)) ? $postdata : $result;
					}
					else
					{
						$this->_field_data[$row['field']]['postdata'] = (is_bool($result)) ? $postdata : $result;
					}
				
					// If the field isn't required and we just processed a callback we'll move on...
					if ( ! in_array('file_required', $rules, TRUE) AND $result !== FALSE)
					{
						return;
					}
				}
				else
				{				
					if ( ! method_exists($this, $rule))
					{
						// If our own wrapper function doesn't exist we see if a native PHP function does. 
						// Users can use any native PHP function call that has one param.
						if (function_exists($rule))
						{
							$result = $rule($postdata);
												
							if ($_in_array == TRUE)
							{
								$this->_field_data[$row['field']]['postdata'][$cycles] = (is_bool($result)) ? $postdata : $result;
							}
							else
							{
								$this->_field_data[$row['field']]['postdata'] = (is_bool($result)) ? $postdata : $result;
							}
						}
											
						continue;
					}

					$result = $this->$rule($postdata, $param);

					if ($_in_array == TRUE)
					{
						$this->_field_data[$row['field']]['postdata'][$cycles] = (is_bool($result)) ? $postdata : $result;
					}
					else
					{
						$this->_field_data[$row['field']]['postdata'] = (is_bool($result)) ? $postdata : $result;
					}
				}
				
				//this line needs testing !!!!!!!!!!!!! not sure if it will work
				//it basically puts back the tested values back into $_FILES
				//$_FILES[$row['field']] = $this->_field_data[$row['field']]['postdata'];
								
				// Did the rule test negatively?  If so, grab the error.
				if ($result === FALSE)
				{			
					if ( ! isset($this->_error_messages[$rule]))
					{
						if (FALSE === ($line = $this->CI->lang->line($rule)))
						{
							$line = 'Unable to access an error message corresponding to your field name.';
						}						
					}
					else
					{
						$line = $this->_error_messages[$rule];
					}
					
					// Is the parameter we are inserting into the error message the name
					// of another field?  If so we need to grab its "field label"
					if (isset($this->_field_data[$param]) && isset($this->_field_data[$param]['label']))
					{
						$param = $this->_field_data[$param]['label'];
					}
					
					// Build the error message
					$message = sprintf($line, $this->_translate_fieldname($row['label']), $param);

					// Save the error message
					$this->_field_data[$row['field']]['error'] = $message;
					
					if ( ! isset($this->_error_array[$row['field']]))
					{
						$this->_error_array[$row['field']] = $message;
					}
					
					return;
				}				
			}		
		}
		else
		{
			log_message('DEBUG', 'Called parent _execute');
			parent::_execute($row, $rules, $postdata,$cycles);
		}
	}
	
	
	/**
	* Future function. To return error message of choice.
	* It will use $msg if it cannot find one in the lang files
	* 
	* @param string $msg the error message
	*/
	function set_error($msg)
	{
		$CI =& get_instance();	
		$CI->lang->load('upload');
		return ($CI->lang->line($msg) == FALSE) ? $msg : $CI->lang->line($msg);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Checks if the a required file is uploaded
	 *
	 * @access	public
	 * @param	mixed $file
	 * @return	bool
	 */
	function file_required($file)
	{
		if ($file['size'] === 0)
		{
			return FALSE;
		}
		
		return TRUE;
	}
	function file_wo_required($file)
	{
		if (isset($file) && isset($file['size']) && $file['size']!== 0)
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Returns FALSE if the file is bigger than the given size
	 *
	 * @access	public
	 * @param	mixed $file
	 * @param	string
	 * @return	bool
	 */
	function file_size_max($file, $max_size)
	{
		$max_size_bit	= $this->let_to_bit($max_size);
		if ($file['size'] > $max_size_bit)
		{
			return FALSE;
		}
		return TRUE;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Returns FALSE if the file is smaller than the given size
	 *
	 * @access	public
	 * @param	mixed $file
	 * @param	string
	 * @return	bool
	 */
	function file_size_min($file,$min_size)
	{
		$max_size_bit	= $this->let_to_bit($max_size);
		if ($file['size'] < $min_size_bit)
		{
			return FALSE;
		}
		return TRUE;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Tests the file extension for valid file types
	 *
	 * @access	public
	 * @param	mixed $file
	 * @param	mixed
	 * @return	bool
	 */
	function file_allowed_type($file,$type)
	{

		//is type of format a,b,c,d? -> convert to array
		$exts = explode(',', $type);
				
		//is $type array? run self recursively
		if (count($exts) > 1)
		{
			foreach ($exts as $v)
			{
				$rc = $this->file_allowed_type($file,$v);
				if ($rc === TRUE)
				{
					return TRUE;
				}
			}
		}
		
		//is type a group type? image, application, word_document, code, zip .... -> load proper array
		$ext_groups						= array();
		$ext_groups['order_form']		= array('xls');
		$ext_groups['image']			= array('jpg', 'jpeg', 'gif', 'png', 'bmp', 'jpe', 'pjpeg', 'svg', 'svgz', 'tif', 'tiff', 'ico', 'xpng', 'psd');
		$ext_groups['application']		= array('exe', 'docx', 'dll', 'so', 'cgi', 'pdf', 'xls', 'xlsx', 'xlc', 'xll', 'xlm', 'xlw', 'ai', 'eps', 'ps', 'swf', 'doc', 'dot');
		$ext_groups['php_code']			= array('php', 'php4', 'php5', 'inc', 'phtml', 'json', 'js', 'xhtml', 'html', 'xht', 'css', 'htm');
		$ext_groups['word_document']	= array('rtf', 'doc', 'docx');
		$ext_groups['compressed']		= array('zip', 'gzip', 'tar', 'gz', 'rar', 'rev', 'gtar', 'z', 'tgz', '7z');
		$ext_groups['document']			= array('txt', 'text', 'doc', 'docx', 'dot', 'dotx', 'word', 'rtf', 'rtx', 'asc', 'csv', 'stm', 'sgm', 'sgml', 'tsv', 'tpl');
		$ext_groups['audio']			= array('aif', 'aifc', 'aiff', 'au', 'kar', 'mid', 'midi', 'mp2', 'mp3', 'mpga', 'ra', 'ram', 'rm', 'rpm', 'snd', 'tsi', 'wav', 'wma');
		$ext_groups['video']			= array('flv', 'fli', 'avi', 'qt', 'mov', 'movie', 'mp3', 'mpa', 'mpv2', 'mpe', 'mpeg', 'mpg', 'mp4', 'viv', 'vivo', 'wmv');
   
		//if there is a group type in the $type var and not a ext alone, we get it
		if (array_key_exists($exts[0], $ext_groups))
		{
			$exts	= $ext_groups[$exts[0]];
		}
		
		$exts_types = array_flip($exts);
		$intersection = @array_intersect_key($this->CI->output->mimes, $exts_types);
		
		//if we can use the finfo function to check the mime AND the mime
		//exists in the mime file of codeigniter...
		if(function_exists ('finfo_open') and !empty($intersection))
		{
				$exts = array();
			
				foreach($intersection as $in)
				{
					if(is_array($in))
					{
						$exts = array_merge($exts, $in);
					}
					else
					{
						$exts[] = $in;
					}
				}
				
				$finfo = finfo_open(FILEINFO_MIME_TYPE);
				$file_type = finfo_file($finfo, $file['tmp_name']);
				
		}
		else
		{
			//get file ext
			$file_type	= strtolower(strrchr($file['name'], '.'));
			$file_type	= substr($file_type,1);			
		}

		if ( ! in_array($file_type, $exts))
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	// --------------------------------------------------------------------

	/**
	 * Tests the file extension for no-valid file types
	 *
	 * @access	public
	 * @param	mixed $file
	 * @param	mixed
	 * @return	bool
	 */
	function file_disallowed_type($file, $type)
	{
		if ($this->file_allowed_type($file, $type) == FALSE)
		{
			return TRUE;
		}

		return FALSE;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Given an string in format of ###AA converts to number of bits it is assignin
	 *
	 * @access	public
	 * @param	string
	 * @return	integer number of bits
	 */
	function let_to_bit($sValue)
	{
		// Split value from name
		if ( ! preg_match('/([0-9]+)([ptgmkb]{1,2}|)/ui', $sValue, $aMatches))
		{ // Invalid input
			return FALSE;
		}
		
		if (empty($aMatches[2]))
		{ // No name -> Enter default value
			$aMatches[2] = 'KB';
		}
		
		if (strlen($aMatches[2]) == 1)
		{ // Shorted name -> full name
		$aMatches[2] .= 'B';
		}
		
		$iBit   = (substr($aMatches[2], -1) == 'B') ? 1024 : 1000;
		// Calculate bits:
		
		switch (strtoupper(substr($aMatches[2],0,1)))
		{
			case 'P':
				$aMatches[1] *= $iBit;
			case 'T':
				$aMatches[1] *= $iBit;
			case 'G':
				$aMatches[1] *= $iBit;
			case 'M':
				$aMatches[1] *= $iBit;
			case 'K':
				$aMatches[1] *= $iBit;
			break;
		}

		// Return the value in bits
		return $aMatches[1];
	}
	
	// --------------------------------------------------------------------

	/**
	 * Returns FALSE if the image is bigger than given dimension
	 *
	 * @access	public
	 * @param	string
	 * @param	array
	 * @return	bool
	 */
	function file_image_maxdim($file, $dim)
	{
		log_message('debug', 'MY_form_validation: file_image_maxdim '.$dim);
		$dim	= explode(',', $dim);
		
		if (count($dim) !== 2)
		{
			// Bad size given
			log_message('error', 'MY_Form_validation: invalid rule, expected similar to 150,300.');
			return FALSE;
		}
		
		log_message('debug', 'MY_form_validation: file_image_maxdim '.$dim[0].' '.$dim[1]);
		
		//get image size
		$d = $this->get_image_dimension($file['tmp_name']);
		
		log_message('debug',$d[0].' '.$d[1]);
		
		if (!$d)
		{
			log_message('error', 'MY_Form_validation: dimensions not detected.');
			return FALSE;		
		}
				
		if ($d[0] <= $dim[0] && $d[1] <= $dim[1])
		{
			return TRUE;
		}
	
		return FALSE;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Returns FALSE if the image is smaller than given dimension
	 *
	 * @access	public
	 * @param	mixed
	 * @param	array
	 * @return	bool
	 */
	function file_image_mindim($file, $dim)
	{
		$dim	= explode(',', $dim);
		
		if(count($dim) !== 2)
		{
			// Bad size given
			log_message('error', 'MY_Form_validation: invalid rule, expected similar to 150,300.');
			return FALSE;
		}
		
		//get image size
		$d	= $this->get_image_dimension($file['tmp_name']);
		
		if (!$d)
		{
			log_message('error', 'MY_Form_validation: dimensions not detected.');
			return FALSE;		
		}
		
		log_message('debug',$d[0].' '.$d[1]);
		
		if ($d[0] >= $dim[0] && $d[1] >= $dim[1])
		{
			return TRUE;
		}
	
		return FALSE;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Returns FALSE if the image is not the given dimension
	 *
	 * @access	public
	 * @param	mixed
	 * @param	array
	 * @return	bool
	 */
	function file_image_exactdim($file, $dim)
	{
		$dim	= explode(',', $dim);
		
		if (count($dim) !== 2)
		{
			// Bad size given
			log_message('error', 'MY_Form_validation: invalid rule, expected similar to 150,300.');
			return FALSE;
		}
		
		//get image size
		$d	= $this->get_image_dimension($file['tmp_name']);
		
		if (!$d)
		{
			log_message('error', 'MY_Form_validation: dimensions not detected.');
			return FALSE;		
		}
		
		log_message('debug', $d[0].' '.$d[1]);
		
		if ($d[0] == $dim[0] && $d[1] == $dim[1])
		{
			return TRUE;
		}
	
		return FALSE;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Attempts to determine the image dimension
	 *
	 * @access	public
	 * @param	mixed
	 * @return	array
	 */
	function get_image_dimension($file_name)
	{
		log_message('debug', $file_name);
		if (function_exists('getimagesize'))
		{
			$D	= @getimagesize($file_name);

			return $D;
		}
		
		return FALSE;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Check if the field's value is in the list
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	function is_exactly($str, $list)
	{
		$list	= str_replace(', ', ',', $list); // Just taking some precautions
		$list	= explode(',', $list);
			
		if ( ! in_array(trim($str), $list))
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	// --------------------------------------------------------------------

	/**
	 * Check if the field's value is not permitted
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	function is_not($str, $list)
	{
		$list	= str_replace(', ', ',', $list); // Just taking some precautions
		$list	= explode(',', $list);
			
		if (in_array(trim($str), $list))
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	// --------------------------------------------------------------------

	/**
	 * Check if the field's value is a valid 24 hour
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function valid_hour($hour, $type)
	{
		if(substr_count($hour, ':') >= 2)
		{
			$has_seconds = TRUE;
		}
		else
		{
			$has_seconds = FALSE;
		}
		
		$pattern = "/^".(($type == '24H')?"([1-2][0-3]|[01]?[1-9])":"(1[0-2]|0?[1-9])").":([0-5]?[0-9])".(($has_seconds)?":([0-5]?[0-9])":"").(($type == '24H')?'':'( AM| PM| am| pm)')."$/";
	 
		if (preg_match($pattern, $hour))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	//
	// Set configuration variables. 
	//
	function set_options($opts, $val = '')
	{
		if(is_array($opts)) {
			foreach($opts AS $key => $row)
				$this->set_option($key, $row);
		} else {
			$this->set_option($opts, $val);
		}
	}
	
	//
	// Set a single option.
	//
	function set_option($key, $val)
	{
		$this->opts[$key] = $val;
	}
	
	//
	// Get options.
	//
	function get_options()
	{
		return $this->opts;
	}
	
	//
	// Clear all configuration settings.
	//
	function clear_options()
	{
		$this->opts = array();
	}
	
	//
	// Return json based on valiation.
	//
	function get_json($extra_array = array(),$error_array=array())
	{
		if(count($extra_array)) {
			foreach($extra_array as $addition_key=>$addition_value) {
				$this->json[$addition_key] = $addition_value;
			}
		}
		$this->json['options'] = $this->opts;
		if(!empty($error_array)){
			foreach($error_array AS $key => $row)
				$error[] = array('field' => $key, 'error' => $row);
		}
		foreach($this->_error_array AS $key => $row)
			$error[] = array('field' => $key, 'error' => $row);
			
			
		if(isset($error)) {
			$this->json['status'] = 'error';
			$this->json['errorfields'] = $error;
		} else {
			$this->json['status'] = 'success';		
		}	
		return json_encode($this->json);
	}
	 function valid_url_format($str){
        $pattern = "|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i";
        if (!preg_match($pattern, $str)){
            $this->set_message('valid_url_format', 'The URL you entered is not correctly formatted.');
            return FALSE;
        }
 
        return TRUE;
    }  
	
}


/* End of file MY_form_validation.php */
/* Location: ./application/libraries/MY_form_validation.php */