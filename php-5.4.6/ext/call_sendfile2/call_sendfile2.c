/*
  +----------------------------------------------------------------------+
  | PHP Version 5                                                        |
  +----------------------------------------------------------------------+
  | Copyright (c) 1997-2012 The PHP Group                                |
  +----------------------------------------------------------------------+
  | This source file is subject to version 3.01 of the PHP license,      |
  | that is bundled with this package in the file LICENSE, and is        |
  | available through the world-wide-web at the following url:           |
  | http://www.php.net/license/3_01.txt                                  |
  | If you did not receive a copy of the PHP license and are unable to   |
  | obtain it through the world-wide-web, please send a note to          |
  | license@php.net so we can mail you a copy immediately.               |
  +----------------------------------------------------------------------+
  | Author:                                                              |
  +----------------------------------------------------------------------+
*/

/* $Id$ */

#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include <stdio.h>
#include "php.h"
#include "php_ini.h"
#include "ext/standard/info.h"
#include "php_call_sendfile2.h"
#include "php_syslog.h"
#include <sys/sendfile2.h>

/* If you declare any globals in php_call_sendfile2.h uncomment this:
ZEND_DECLARE_MODULE_GLOBALS(call_sendfile2)
*/

/* True global resources - no need for thread safety here */
static int le_call_sendfile2;

/* {{{ call_sendfile2_functions[]
 *
 * Every user visible function must have an entry in call_sendfile2_functions[].
 */
const zend_function_entry call_sendfile2_functions[] = {
	PHP_FE(confirm_call_sendfile2_compiled,	NULL)		/* For testing, remove later. */
	PHP_FE_END	/* Must be the last line in call_sendfile2_functions[] */
};
/* }}} */

/* {{{ call_sendfile2_module_entry
 */
zend_module_entry call_sendfile2_module_entry = {
#if ZEND_MODULE_API_NO >= 20010901
	STANDARD_MODULE_HEADER,
#endif
	"call_sendfile2",
	call_sendfile2_functions,
	PHP_MINIT(call_sendfile2),
	PHP_MSHUTDOWN(call_sendfile2),
	PHP_RINIT(call_sendfile2),		/* Replace with NULL if there's nothing to do at request start */
	PHP_RSHUTDOWN(call_sendfile2),	/* Replace with NULL if there's nothing to do at request end */
	PHP_MINFO(call_sendfile2),
#if ZEND_MODULE_API_NO >= 20010901
	"0.1", /* Replace with version number for your extension */
#endif
	STANDARD_MODULE_PROPERTIES
};
/* }}} */

#ifdef COMPILE_DL_CALL_SENDFILE2
ZEND_GET_MODULE(call_sendfile2)
#endif

/* {{{ PHP_INI
 */
/* Remove comments and fill if you need to have entries in php.ini
PHP_INI_BEGIN()
    STD_PHP_INI_ENTRY("call_sendfile2.global_value",      "42", PHP_INI_ALL, OnUpdateLong, global_value, zend_call_sendfile2_globals, call_sendfile2_globals)
    STD_PHP_INI_ENTRY("call_sendfile2.global_string", "foobar", PHP_INI_ALL, OnUpdateString, global_string, zend_call_sendfile2_globals, call_sendfile2_globals)
PHP_INI_END()
*/
/* }}} */

/* {{{ php_call_sendfile2_init_globals
 */
/* Uncomment this function if you have INI entries
static void php_call_sendfile2_init_globals(zend_call_sendfile2_globals *call_sendfile2_globals)
{
	call_sendfile2_globals->global_value = 0;
	call_sendfile2_globals->global_string = NULL;
}
*/
/* }}} */

/* {{{ PHP_MINIT_FUNCTION
 */
PHP_MINIT_FUNCTION(call_sendfile2)
{
	/* If you have INI entries, uncomment these lines 
	REGISTER_INI_ENTRIES();
	*/
	return SUCCESS;
}
/* }}} */

/* {{{ PHP_MSHUTDOWN_FUNCTION
 */
PHP_MSHUTDOWN_FUNCTION(call_sendfile2)
{
	/* uncomment this line if you have INI entries
	UNREGISTER_INI_ENTRIES();
	*/
	return SUCCESS;
}
/* }}} */

/* Remove if there's nothing to do at request start */
/* {{{ PHP_RINIT_FUNCTION
 */
PHP_RINIT_FUNCTION(call_sendfile2)
{
	return SUCCESS;
}
/* }}} */

/* Remove if there's nothing to do at request end */
/* {{{ PHP_RSHUTDOWN_FUNCTION
 */
PHP_RSHUTDOWN_FUNCTION(call_sendfile2)
{
	return SUCCESS;
}
/* }}} */

/* {{{ PHP_MINFO_FUNCTION
 */
PHP_MINFO_FUNCTION(call_sendfile2)
{
	php_info_print_table_start();
	php_info_print_table_header(2, "call_sendfile2 support", "enabled");
	php_info_print_table_end();

	/* Remove comments if you have entries in php.ini
	DISPLAY_INI_ENTRIES();
	*/
}
/* }}} */


/* Remove the following function when you have succesfully modified config.m4
   so that your module can be compiled into PHP, it exists only for testing
   purposes. */

/* Every user-visible function in PHP should document itself in the source */
/* {{{ proto string confirm_call_sendfile2_compiled(string arg)
   Return a string to confirm that the module is compiled in */
PHP_FUNCTION(confirm_call_sendfile2_compiled)
{
	char *arg = NULL;
	char *extra_cmd=NULL;
	
	zval *sock_fp;
	zval *file_fp;
	long offset;
	//file size가 int형을 넘어서 long으로 change	
	long size;
	int sock_fp_len, file_fp_len, size_len, offset_len;

	php_stream *stream_sock_fd;
	php_stream *stream_file_fd;

	int total_size;
	int sock_fd;
	int file_fd;

	int len;
	char *strg;

	//2014.5.12 3:29 sanghyun modfiy start
	//FILE *stram_after_sock_fp;
	//FILE *stream_after_file_fp;
	//2014.5.12 3:29 sanghyun modfiy end
	//php_mail_log_to_syslog("asdffffff");

	//parameter type is "rrss"
	//
	/*if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rrss", &sock_fp, &sock_fp_len, &file_fp, &file_fp_len, &offset, &offset_len, &size, &size_len) == FAILURE) {
		return ;
	}*/

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rrll", &sock_fp, &file_fp, &offset, &size) == FAILURE) {
		return ;
	}
	//php_mail_log_to_syslog("asdffffffFFFFFFFFFFFFFFFFFFF");

	if(offset  == 0)
		php_mail_log_to_syslog("offset size is 0");		
	else
		php_mail_log_to_syslog("offset size is error");

	if(size < 0)
		php_mail_log_to_syslog("file size is error");
	else
		php_mail_log_to_syslog("file size is OK");		

	char temp[100]={0};
	sprintf(temp, "offset :%d\n", offset);
	php_mail_log_to_syslog(temp);
	char temp1[100]={0};
	sprintf(temp1, "offset :%d\n", size);
	php_mail_log_to_syslog(temp1);
	//php_mail_log_to_syslog("offset :%d\n", offset);
	//php_syslog(LOG_NOTICE,"%l",offset);
	//php_mail_log_to_syslog("size : %d\n", size);
	//php_syslog(LOG_NOTICE,"%l",size);
	php_mail_log_to_syslog("sh");
	php_stream_from_zval(stream_sock_fd, &sock_fp);
	php_mail_log_to_syslog("hc");
	php_stream_from_zval(stream_file_fd, &file_fp);
	php_mail_log_to_syslog("shsh");

	if(php_stream_cast(stream_sock_fd, PHP_STREAM_AS_SOCKETD, (void**)&sock_fd, REPORT_ERRORS) == FAILURE)
		return;
	php_mail_log_to_syslog("shshsh");
	if(php_stream_cast(stream_file_fd, PHP_STREAM_AS_FD, (void**)&file_fd, REPORT_ERRORS) == FAILURE)
		return;
	php_mail_log_to_syslog("shshshsh");
	total_size = sendfile2(sock_fd, file_fd, offset, size);
	php_mail_log_to_syslog("shshshshsh");	
	RETURN_LONG(total_size);
	 
	// 2014.5.12 3:29 sanghyun modfiy start
	//total_size = php_sendfile2(sock_fd,file_fd,offset,size, *extra_cmd TSRMLS_CC);
	//RETURN_LONG(sock_fd);
	//stram_after_sock_fp = stream_sock_fd->stdiocast;
	//stream_after_file_fp = stream_file_fd->stdiocast;
	//total_size = php_sendfile2(stram_after_sock_fp,stream_after_file_fp,offset,size, *extra_cmd TSRMLS_CC);
	//RETURN_LONG(total_size);
	// 2014.5.12 3:29 sanghyun modfiy end 

	
	//sock_fd = fileno(&sock_fp);
	//file_fd = fileno(stream_file_fd);

	//RETURN_LONG(sock_fd);
	//total_size = php_sendfile2(sock_fp,file_fp,offset,size, *extra_cmd TSRMLS_CC);
	
	
	
/*********ORIGINAL CODE*********
	char *arg = NULL;
	FILE *sock_fp;
	FILE *file_fp;
	char *extra_cmd=NULL;
	int size, offset;
	int sock_fp_len, file_fp_len, size_len, offset_len;

	int total_size;
	
	int len;
	char *strg;

	php_mail_log_to_syslog("asdffffff");

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "OOss", &sock_fp, &sock_fp_len, &file_fp, &file_fp_len,  &offset, &offset_len, &size, &size_len) == FAILURE) {
		return ;

	}

	php_mail_log_to_syslog("asdffffffFFFFFFFFFFFFFFFFFFF");

	len = spprintf(&strg, 0, "Congratulations! You have successfully modified ext/%.78s/config.m4. Module %.78s is now compiled into PHP.", "call_sendfile2", arg);
	len = spprintf(&strg,0,"Congratulations!");
	RETURN_STRINGL(strg, len, 0);

*********ORIGINAL CODE*********/

}

/* }}} */
/* The previous line is meant for vim and emacs, so it can correctly fold and 
   unfold functions in source code. See the corresponding marks just before 
   function definition, where the functions purpose is also documented. Please 
   follow this convention for the convenience of others editing your code.
*/
PHPAPI int php_sendfile2(FILE *sock_fp, FILE *file_fp, int offset, int size, char *extra_cmd TSRMLS_DC)
{
	//int sock_fd;
	//int file_fd;
	
	//2014.5.12 3:29 sanghyun modfiy start
	//php_stream *stream_sock_fd;
	//php_stream *stream_file_fd;
	int sock_fd;
	int file_fd;
	sock_fd = fileno(sock_fp);
	file_fd = fileno(file_fp);
	php_mail_log_to_syslog("shshsh");
	return sendfile2(sock_fd,file_fd , offset, size);
	//2014.5.12 3:29 sanghyun modfiy end



	//sock_fd = fileno(sock_fp);
	//file_fd = fileno(file_fp);

	//return sendfile2(, stream_file_fd, offset, size);	
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */
