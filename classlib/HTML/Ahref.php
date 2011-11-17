<?php

/**
 * Description of Textbox
 *
 * @author Aaron
 */
class ROCKETS_HTML_Ahref extends ROCKETS_HTML_Form 
{	
	const ELEMENT = 'A';
	
    /**
     * Auto-draws a link
     * 
	 * Required: $options['name'],$options['value']
	 * 
     * @param type $name name of the INPUT
     * @param type $obj object used to retrieve value
	 * @param boolean $options['read only'] activate read only 
	 * @param int $options['size'] custom input size
     */
    static public function draw($options = array(null))
    {
		$element = self::ELEMENT;
		$attributes = array(
			'href','id','class','target','name','rel'
		);
		
		$attributes_html = self::get_attributes($options, $attributes);
		
        $html = "<{$element} {$attributes_html}>{$options['value']}</{$element}>";
		
		return self::dl_wrap($html, $options);
    }
	
	static public function get_attributes($options, $attributes)
	{	
		$return_html = "";
		
		foreach($attributes as $attribute) 
		{
			if(isset($options[$attribute]))
			{
				$return_html .= " {$attribute}='{$options[$attribute]}'";
			}
		}
		return $return_html;
	}
}

?>