#!/bin/bash

#for i in *; do echo -n "$i "; ls $i | wc -l; done;
for i in *
do
	count=`ls $i | wc -l`
	printf "$count\t$i\n"
done
