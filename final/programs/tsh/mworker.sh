#/bin/bash 
cd ../apps/matrix
touch *.c
export LD_LIBRARY_PATH=../../mysql-connector/lib
make SIZE=2000
#$1 is argument one which is the port and $2 is arguement 2 which is the granuility
#./mmaster $1 $2
./mworker $1 $2 
