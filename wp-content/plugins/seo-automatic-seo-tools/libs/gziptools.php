<?php
/**
 * GZipTools
 * @package SEOInspector
 */
class GZipTools {
	/**
	 * Just as filesize($file) returns the size of the file in bytes,
	 * compression_filesize($str) returns the number of bytes in a string
	 * after compressing it with gzip. This is useful for predicting
	 * the compression ratio.
	 *
	 * @param string $string
	 * @return int Bytes in gzipped $string
	 */
	function compression_filesize($string) {
		$filename = 'gzip_filesize_' . crc32($string) . '.txt.gz';
		if ( file_put_contents("compress.zlib:///tmp/$filename", $string) ) {
			$gzip_filesize = filesize("/tmp/$filename");
			unlink("/tmp/$filename");
			return( $gzip_filesize );
		} else {
			return(false);
		}
	}

	/**
	 * Calculate the gzip compression ratio of a string
	 *
	 * @param string Your uncompressed string
	 * @return float Compression ratio (%)
	 */
	function compression_ratio($string) {
		$compressed = self::compression_filesize($string);
		return ( ($compressed / strlen($string) ) * 100 );
	}
}

?>
