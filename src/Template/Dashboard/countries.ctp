<?php
foreach ($countries as $row) {
    echo $row->get("countrySpecialName") . '<br>';
}
