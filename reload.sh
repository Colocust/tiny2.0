#!/bin/bash
echo "loading..."
pid=`pidof HTTP_SERVER`
echo $pid
kill -USR1 $pid
echo "loading success"