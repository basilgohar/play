<?php

$people = new People();

if (isset($_GET['subject_id'])) {
    require_once 'index_person_single.php';
} else {
    require_once 'index_person_all.php';
}
