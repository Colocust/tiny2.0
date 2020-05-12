#!/bin/bash
php Integrator.php
echo "inte"

pid=`pidof HTTP_SERVER`
echo $pid
kill -USR1 $pid
echo "loading success"