<?php

function person_can_marry(Zend_Db_Table_Row $husband, Zend_Db_Table_Row $wife)
{
	if ($husband->gender != 'male' || $wife->gender != 'female') {
		return false;
	} else {
		return true;
	}
}


