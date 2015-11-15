#!/bin/bash

function say_hell()
{
	if [ 1=1 ]
		then
			echo 'hello'
			fi

# 如果不存在
			color='blue'
			echo "${color:-grey}" #显示不赋值
			echo "${color}"

			color=''
			echo "${color:=grey}" #显示并赋值
			echo "${color}"

			color=''
			echo "${color:? not color}" #如果不存在, 提示错误信息

# 如果存在
			color='hello'
			echo "${color:+grey}" #如果存在, 显示grey
			echo "${color}"

}

function argfun()
{
	name=$1 
		echo "`basename $0` calling"
		echo "this first arg: ${name}"
}


#argfun 'maxfine'

function findfun
{
	find ~/ -name $1
}

#findfun $1

function iffunc()
{
	if [ -n "$1" ]; then
		echo "-n判断非空: \$1=$1"
	else
		echo "-n判断非空: \$1为空"

	fi



if [ "$1" -gt "$2" ]; then
	echo "$1 > $2" 
		fi

		if [ -e "$1" ]; then 
			echo "-e $1 == true"
					else
						echo "-e $1 == flase"
							fi

							if [ -f "$1" ]; then 
								echo "-f $1 == true"
							else
								echo "-f $1 == flase"
									fi


									if [ -d "$1" ]; then 
										echo "-d $1 == true"
									else
										echo "-d $1 == flase"
											fi

											if [ -w "$1" ]; then 
												echo "-w $1 == true"
											else
												echo "-w $1 == flase"
													fi
}

#iffunc "$1" "$2"
