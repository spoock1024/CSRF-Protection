<?php
/*the class for randomizing parameter name of very http request 
to against the CSRF Attack. 
Author:ben 
Date:2015/03/06
*/
class CSRFP_Randomization
{
    //store the randomkey for very connection
	public static $randomkey="";
	
	//initial function of the class
	public static init()
	{
	    //initial the randomkey
	    $randomkey=self::GenerateRandomkey();
		//set the randomkey session
		self::StartRandomkeySession();	
	}
	//function to generate the key(32) for randomizing the parameter name
	public static public static function GenerateRandomkey()
	{
	    $key="";
		for ($i=0;$i<32;$i++)
		{   //tha range of visible string ascii value:33~126
		    $r=random(33,126);
			$key.=chr($r);
		}
		//attention:there is something wrong,sometimes the length of the key generated is not as enough as 32
		return $key;
	}
	
	//function to randomize the parameter name with a random key
	public static function Randomization($parameter,$randomkey)
	{
	    //joint the two string as the plaintext
	    $plainstr=$parameter.$randomkey;
		//using md5 algorithm
		return md5($plainstr);
	}
	
	//function to set session value for randomkey
	public static function StartRandomkeySession()
	{
	    if(!isset($_SESSION))
		{
		    session_start();
        }
		$_SESSION['randomkey']=self::$randomkey;
	}
	
	//function to package http request methods:request
	public static function REQUESTR($parameter)
	{
	    //if the randomkey session has been setted
	    if(!isset($_SESSION['randomkey']))
		{   //didn't set
		    // echo "randomkey should be setted first!";
			//return null;
			die("randomkey should be set first!");
		}
		else
		{   //already set
		    $random_parameter=self::Randomization($parameter,self::$randomkey);
			$result=$_REQUEST[$random_parameter];
			return $result;
		}
	}
	
    //function to package http request methods:get
	public static function GETR($parameter)
	{
	    //if the randomkey session has been setted
	    if(!isset($_SESSION['randomkey']))
		{    //didn't set
		    die("randomkey should be set first!");
		}
		else
		{   //already set
		    $random_parameter=self::Randomization($parameter,self::$randomkey);
			$result=$_GET[$random_parameter];
			return $result;
		}
	}
	
	//function to package http request methods:post
	public static function POSTR($parameter)
	{
	    //if the randomkey session has been setted
	    if(!isset($_SESSION['randomkey']))
		{    //didn't set
		    die("randomkey should be set first!");
		}
		else
		{   //already set
		    $random_parameter=self::Randomization($parameter,self::$randomkey);
			$result=$_POST[$random_parameter];
			return $result;
		}
	}
}
?>
