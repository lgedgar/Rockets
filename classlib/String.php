<?php

/*
 * String class, containing generic string-related functions
 */

Class ROCKETS_String
{

    /**
     * Alias for ucwords - turns "jill hill" into "Jill Hill"
     * 
     * @param type $str
     * @return type 
     */
    static public function capitalizeName($str)
    {
		$str = strtolower($str); // WASHINGTON => washington
        return ucwords($str); //    washington => Washington
    }

    /**
     * <p>Gets rid of extra spaces in between words and at the end/beginning of string.</p>
     * @param string $str any string
     * @return string cleaned up string
     */
    public static function removeSpaces($str)
    {
        return preg_replace("/[ ]+/", " ", trim($str));
    }

    /**
     * Strip extension from filename (e.g. "hello.txt" => "hello"
     * @param <type> $filename
     * @return <type>
     */
    public static function stripExtension($filename)
    {
        $path_parts = pathinfo($filename);
        return $path_parts['filename'];
    }

    /**
     * Remove anything that's not a letter or a number and turn the character into whitespace.
     * E.g. "this-is-a-house_by_the_lake" => "this is a house by the lake"
     * Used to clean CSV lines
     * 
     * @param <type> $str
     * @return <type>
     */
    public static function removeCharacters($str)
    {
        return preg_replace("/[^a-z0-9]/i", " ", $str);
    }

    /**
     * Clean phone number string entered by user.
     * Given "(111) 111-1111
     * @param <type> $string
     * @return string
     */
    public static function cleanPhone($string)
    {
        $string = str_replace(" ", "", $string);
        $string = str_replace("-", "", $string);
        $string = str_replace(array("(", ")"), "", $string);
        $string = substr($string, 0, 3) . "-" . substr($string, 3, 3) . "-" . substr($string, 6, 4);
        return $string;
    }

    /**
     * reduce any phone number into numbers, e.g. (123) 234-1234 => 12342341234
     * @param <type> $string
     * @return string
     */
    public static function stripPhone($string)
    {
        $string = str_replace(" ", "", $string);
        $string = str_replace("-", "", $string);
        $string = str_replace(array("(", ")"), "", $string);
        return $string;
    }

    /**
     * pad zip code when its an integer
     */
    public static function padZip($str)
    {
        return str_pad($str, 6, "0", STR_PAD_LEFT);
    }

    /**
     * takes a 6 digit zip 95123 and extension 1234 => combine into 95123-1234
     * */
    public static function mergeZip($zip, $ext)
    {
        if ($ext == "")
            return $zip;
        else
            return $zip . "-" . $ext;
    }
	
	/**
	 * Merge two strings and return a combined string
	 * Example: $string1 = "create,delete,edit"; $string2 = "create"; return value => "create,delete,edit"
	 * 
	 * @param type $string1
	 * @param type $string2
	 * @return type 
	 */
	
	static public function merge_comma_delimited_strings($string1, $string2) 
	{
		$ar1 = explode(",", $string1);
		$ar2 = explode(",", $string2);
		$combined_ar = array_merge($ar1, $ar2); // combine arrays, produces dupes
		$combined_ar = array_unique($combined_ar); // get rid of dupe values
		$result = implode(",", $combined_ar);
		return $result;
	}

    /**
     * Split phone number into 3 components
     */
    public static function splitPhone($string)
    {
        $string = self::stripPhone($string);
        $ar[0] = substr($string, 0, 3);
        $ar[1] = substr($string, 3, 3);
        $ar[2] = substr($string, 6, 4);
        return $ar;
    }

    /**
     * merge 3 variables into a phone number string
     * used to handle phone input from forms that splits up # into 3 parts.
     */
    public static function mergePhone($ar = array(null))
    {
        return implode($ar);
    }

    /**
     * Add a space after every comma (e.g. "cookies,sandwiches.." -> "cookies, sandwiches")
     * @param string $str
     * @return string
     */
    public static function fixComma($str)
    {
        $str = preg_replace("/,([^ ])/", ", $1", $str);
        return $str;
    }

    /**
     * Get rid of all caps from a sentence 
     * Capitalize the first letter of the string.
     * This method fixes text that contain all capped words.
     *
     * @param string $sentence
     * @return string
     */
    public static function fixCase($sentence)
    {
        $sentence = strtolower($sentence);
        $sentence = ucfirst($sentence);
        return $sentence;
    }

    /**
     * This method fixes text so &amp is used instead of &, so that the resulting HTML is wc3 compliant.
     *
     * @param string $str
     * @return string
     */
    public static function fixAmpr($str)
    {
        return str_replace("&", "&amp;", $str);
    }

    /**
     * Clean string - a combination of string functions to clean up a sentence for HTML output
     * @param string $str
     * @return string
     */
    public static function cleanStr($str)
    {
        $str = self::fixComma($str);
        $str = self::fixCase($str);
        $str = self::fixAmpr($str);
        return $str;
    }

    /**
     * Format MYSQL query for pretty output
	 * 
     * @param string $subject MYSQL query string
     * @return <type>
     */
    static public function mysql_prettify($subject)
    {
        /**
         * @todo different types of joins don't work cleanly.
         * 
         */
        $subject = preg_replace("/FROM/", PHP_EOL . "<br>FROM", $subject);
        $subject = preg_replace("/(LEFT JOIN|JOIN|LEFT OUTER JOIN|INNER JOIN|RIGHT JOIN)/", PHP_EOL . "<br>$1", $subject);
        $subject = preg_replace("/AND/", PHP_EOL . "<br>AND", $subject);
        $subject = preg_replace("/OR/", PHP_EOL . "<br>OR", $subject);
        $subject = preg_replace("/WHERE/", PHP_EOL . "<br>WHERE", $subject);
        $subject = preg_replace("/ORDER BY/", PHP_EOL . "ORDER BY", $subject);
        $subject = preg_replace("/GROUP BY/", PHP_EOL . "<br>GROUP BY", $subject);
        $subject = preg_replace("/LIMIT/", PHP_EOL . "<br>LIMIT", $subject);
        $subject = "<h2>Query</h2>" . $subject . "<br><br>";
        return $subject;
    }

    /**
     * Takes a string like "user database" and turns it into "UserDatabase"
     * @param <type> $string
     */
    static public function camelCase($string)
    {
        return str_replace(" ", "", ucwords($string)); // capitalize first letter of each word and remove spaces
    }

    /**
     * Remove camel casing: e.g: "HellsKitchen" -> "Hells Kitchen"
     * Useful for reconstruct MYSQL table name from class names, and class name contains camel casing.
     *
     * @param <type> $string
     * @return <type>
     */
    static public function unCamelCase($string)
    {
        return preg_replace('/(?!^)[A-Z]{2,}(?=[A-Z][a-z])|[A-Z][a-z]|[0-9]{1,}/', ' $0', $string);
    }

    /**
     * Takes a word and make it plural. For example, "job" => "jobs", "company" => "companies",
     * "status" => "status"
     * Used primarily to take a class name and reconconstruct a MYSQL table name,
     * which is useful for auto-generating MYSQL queries.
     * 
     * @param type $string
     * @return type 
     */
    static public function makePlural($string)
    {
        $last_char = substr($string, strlen($string) - 1, 1); // get the last char of a word
        switch ($last_char) {
            case "y": // "companY" -> "companIES"
                $string = substr($string, 0, strlen($string) - 1) . "ies"; // get rid of the "y"
                break;
            case "s": // "statuS" -> "statuS"
                break;
            default: // "job" -> "jobS"
                $string = $string . "s";
                break;
        }
        return $string;
    }

    /**
     * Takes a word and makes it singular
     * Used to take a table name and to create a Model class name - used for auto constructing relational queries
     * 
     * @param String $subject - could be a single word "users" or multiple words like "users roles"
     * @return String $singular_phrase
     */
    static public function makeSingular($subject)
    {
        $singular_phrase = "";
        $words = explode(" ", $subject); // in case there are more than one word in $subject
		$first = true; // count number of words to put spaces in between
        foreach ($words as $word)
        {
            $word = preg_replace("/ies$/i", "y", $word); // companies => company
            $word = preg_replace("/([^iaou])s$/i", "$1", $word); // roles => role,  status => status
			if(!$first) $singular_phrase .= " "; // ad space between words, so "job type" doesn't turn into "jobtype"
            $singular_phrase .= $word;
			$first = false;
        }
        return $singular_phrase;
    }

    /**
     * OVERRIDE
     * takes a string like "(111) 111-1111" and returns 1111111111
     * Used for storing phone numbers in MYSQL
     * 
     * @param String $subject 
     */
    static public function phone_strip($subject)
    {
        return preg_replace("/[ .()-]*/i", "", $subject);
    }

    /**
     * Convert 00000000 into (000) 000-0000
     * 
     * @param String $str
     * @return type 
     */
    static public function phone_format($str)
    {
        $len = strlen($str);
        if ($len == 7)
        { // xxx-xxxx
            $str = preg_replace('/([0-9]{3})([0-9]{4})/', '$1-$2', $str);
        }
        elseif ($len == 10)
        { // (xxx) xxx-xxxx
            $str = preg_replace('/([0-9]{3})([0-9]{3})([0-9]{4})/', '($1) $2-$3', $str);
        }
        elseif ($len == 13)
        { // (xxx) xxx-xxxx ext xxx
            $str = preg_replace('/([0-9]{3})([0-9]{3})([0-9]{4})([0-9]{3})/', '($1) $2-$3 ext $4', $str);
        }

        return $str;
    }

    /**
     * do a formatted print_r, so contents look formatted on the screen.
     * 
     * @param array $ar 
     * @param string $title (optiona) title to say what $ar is
     */
    static public function echo_array_formatted($ar, $title = "")
    {
        echo "<h2>{$title}</h2>";
        echo "<pre>";
        print_r($ar);
        echo "</pre>";
    }

    /**
     * <p>Create a string of items in quotes to use in a mysql IN statement
     * 
     * <code>
     * $array = array("apple","orange","pear");
     * $str = JOB_LTC_String::mysql_get_in_list($array);
     * </code>
     * 
     * $str would equal "'apple','orange','pear'" which can be used in a MYSQL query like
     * <code>
     * WHERE fruit IN ('apple','orange','pear')
     * </code>
     * 
     * Without the quotes, the query would break.
     * </p>
     * 
     * @param array $ar
     * @return type 
     */
    static public function mysql_get_in_list(Array $ar)
    {
        $str = "";
        $first = true;

        foreach ($ar as $item)
        {
            if ($first == false)
                $str .= ",";
            $str .= "'" . mysql_real_escape_string($item) . "'";
            $first = false;
        }
        return $str;
    }
	
	/**
	 * Turn an array of emails into a string
	 * Example: array('xyz@gmail.com','abc@hotmail.com') => xyz@gmail.com;abc@hotmail.com;...
	 * @param type $emails 
	 */
	static public function email_array_to_string($emails)
	{
		return implode(';', $emails);
	}

	/**
	 * Extract first name from full name:
	 * 
	 * Example: get_first_name("Joe shmoe") => "Joe"
	 * 
	 * @param type $full_name
	 * @return type 
	 */
	static public function get_first_name($full_name)
	{
		$names = explode(" ",trim($full_name));
		return $names[0];
	}
}

?>
