dnl $Id$
dnl config.m4 for extension call_sendfile2

dnl Comments in this file start with the string 'dnl'.
dnl Remove where necessary. This file will not work
dnl without editing.

dnl If your extension references something external, use with:

dnl PHP_ARG_WITH(call_sendfile2, for call_sendfile2 support,
dnl Make sure that the comment is aligned:
dnl [  --with-call_sendfile2             Include call_sendfile2 support])

dnl Otherwise use enable:

dnl PHP_ARG_ENABLE(call_sendfile2, whether to enable call_sendfile2 support,
dnl Make sure that the comment is aligned:
dnl [  --enable-call_sendfile2           Enable call_sendfile2 support])

if test "$PHP_CALL_SENDFILE2" != "no"; then
  dnl Write more examples of tests here...

  dnl # --with-call_sendfile2 -> check with-path
  dnl SEARCH_PATH="/usr/local /usr"     # you might want to change this
  dnl SEARCH_FOR="/include/call_sendfile2.h"  # you most likely want to change this
  dnl if test -r $PHP_CALL_SENDFILE2/$SEARCH_FOR; then # path given as parameter
  dnl   CALL_SENDFILE2_DIR=$PHP_CALL_SENDFILE2
  dnl else # search default path list
  dnl   AC_MSG_CHECKING([for call_sendfile2 files in default path])
  dnl   for i in $SEARCH_PATH ; do
  dnl     if test -r $i/$SEARCH_FOR; then
  dnl       CALL_SENDFILE2_DIR=$i
  dnl       AC_MSG_RESULT(found in $i)
  dnl     fi
  dnl   done
  dnl fi
  dnl
  dnl if test -z "$CALL_SENDFILE2_DIR"; then
  dnl   AC_MSG_RESULT([not found])
  dnl   AC_MSG_ERROR([Please reinstall the call_sendfile2 distribution])
  dnl fi

  dnl # --with-call_sendfile2 -> add include path
  dnl PHP_ADD_INCLUDE($CALL_SENDFILE2_DIR/include)

  dnl # --with-call_sendfile2 -> check for lib and symbol presence
  dnl LIBNAME=call_sendfile2 # you may want to change this
  dnl LIBSYMBOL=call_sendfile2 # you most likely want to change this 

  dnl PHP_CHECK_LIBRARY($LIBNAME,$LIBSYMBOL,
  dnl [
  dnl   PHP_ADD_LIBRARY_WITH_PATH($LIBNAME, $CALL_SENDFILE2_DIR/lib, CALL_SENDFILE2_SHARED_LIBADD)
  dnl   AC_DEFINE(HAVE_CALL_SENDFILE2LIB,1,[ ])
  dnl ],[
  dnl   AC_MSG_ERROR([wrong call_sendfile2 lib version or lib not found])
  dnl ],[
  dnl   -L$CALL_SENDFILE2_DIR/lib -lm
  dnl ])
  dnl
  dnl PHP_SUBST(CALL_SENDFILE2_SHARED_LIBADD)

  PHP_NEW_EXTENSION(call_sendfile2, call_sendfile2.c, $ext_shared)
fi
