#!/bin/bash
#
#	/etc/init.d/Daemon
#
# Starts the at daemon
#
#chkconfig: 345 95 5
# description: Runs the demonstration daemon.
# processname: Daemon
 
# Source function library.
. /lib/lsb/init-functions

#startup values
log=/var/www/html/smsApp/newfile.txt
 
#verify that the executable exists
test -x /var/www/html/smsApp/Daemon.php || exit 0RETVAL=0
 
#
#	Set prog, proc and bin variables.
#
prog="Daemon"
proc=/var/lock/subsys/Daemon
bin=/var/www/html/smsApp/Daemon.php
 
start() {
	# Check if Daemon is already running
	if [ ! -f $proc ]; then
	    echo -n $"Starting $prog: "
	    start_daemon $bin --log=$log
	    RETVAL=$?
	    [ $RETVAL -eq 0 ] && touch $proc
	    echo
	fi
 
	return $RETVAL
}
 
stop() {
	echo -n $"Stopping $prog: "
	killproc $bin
	RETVAL=$?
	[ $RETVAL -eq 0 ] && rm -f $proc
	echo
        return $RETVAL
}
 
restart() {
	stop
	start
}	
 
reload() {
	restart
}	
 
status_at() {
 	status_of_proc $bin
}
 
case "$1" in
start)
	start
	;;
stop)
	stop
	;;
reload|restart)
	restart
	;;
condrestart)
        if [ -f $proc ]; then
            restart
        fi
        ;;
status)
	status_at
	;;
*)
 
echo $"Usage: $0 {start|stop|restart|condrestart|status}"
	exit 1
esac
 
exit $?
exit $RETVAL
