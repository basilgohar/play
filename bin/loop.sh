#!/bin/bash

index=0

if [ ! -z "$1" ]; then
	limit=$1
else
	limit=10000
fi

timestart=`date +%s.%N`

while [ $index -lt $limit ]; do
	let index=index+1;
done;

timeend=`date +%s.%N`

timetotal=`echo "$timeend - $timestart" | bc`

echo "Processed $index iterations in $timetotal seconds"
