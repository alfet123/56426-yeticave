<?php

function includeTemplate($file, $data)
{
    if (file_exists($file)) {
        foreach ($data as $key => $value) {
            $data[$key] = htmlspecialchars($value);
        }
        ob_start();
        include($file);
        $result = ob_get_clean();
    } else {
        $result = "";
    }

    return $result;
}

?>
