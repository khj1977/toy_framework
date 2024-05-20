<?php

// Format of migration
// CSV
// up/down
// def column, add column, drop column

// up,command,col name,type,structure(space separated)
// up,add_column,a_col,integer(11),unsigned NOT NULL
// if up is made, down is automatically, made
// down,dropcolumn,a_col

// version control of miration
// record of migrations is retained in a table
// int/PRI KEY,varchar(128),varchar(128),varchar(128),varchar(256)
// id, up/down, commmand, col_name, structure

// debug
// implement this class
// end of debug

?>