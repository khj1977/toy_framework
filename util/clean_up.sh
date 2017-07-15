#!/bin/bash

# @Auther Hwi Jun KIM. euler.bonjour@gmail.com
# See License.txt for license of this code.

# fix around "find ." with respect to handling current dir. not so important.i
for f in `find . -type f -name '*~'`; do echo $f; rm $f; done
