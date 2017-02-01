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

function ft_catalog_by_type($catalog, $currentPage)
{
    $title = [];
    foreach ($catalog as $id => $item)
    {
        if (strtolower($item["category"]) == strtolower($currentPage) || $currentPage == null)
        {
            $tmp = ltrim($item["title"], "The ");
            $tmp = ltrim($item["title"], "A ");
            $tmp = ltrim($item["title"], "An ");
            $title[$id] = $tmp;
        }
    }
    asort($title);
    return array_keys($title);
}
