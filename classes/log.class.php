<?php

	class cLog {
		///<summary>
		///Log a given message if logging is activated
		///Return values: Success => number of bytes written | Failure => false
		///</summary>
		public static function Log($message)
		{
			if(!is_dir("./logs"))
			{
				mkdir("./logs", 0644);
			}
			return @file_put_contents("logs/ucvs_" . date("Ymd") . ".log", 
				"[" . date("H:i:s") . "] " . $message . "\r\n",
				FILE_APPEND
			);
			
		}
		
		///<summary>
		///Log a given error message if logging is activated
		///Return values: Success => number of bytes written | Failure => false
		///</summary>
		public static function ErrorLog($message)
		{
			if(!is_dir("./logs"))
			{
				mkdir("./logs", 0644);
			}
			return @file_put_contents("logs/error_" . date("Ymd") . ".log", 
				"[" . date("H:i:s") . "] " . $message . "\r\n",
				FILE_APPEND
			);
			
		}
	}

?>