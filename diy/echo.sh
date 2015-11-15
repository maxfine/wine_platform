#!/bin/bash

dd=1234
ddd=$(echo $dd|sed 's/123/456/g')
echo $ddd

echo $(echo 'hello')
