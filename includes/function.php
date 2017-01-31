<?php
function ft_get_html_by_id($id, $item)
{
    $returns =  "<li>
                    <a href='#'>
                        <img src='" . $item["img"] . "' alt='" . $item["title"] . "'>
                        <p>View Details</p>
                    </a>
                </li>";
    return $returns;
}
