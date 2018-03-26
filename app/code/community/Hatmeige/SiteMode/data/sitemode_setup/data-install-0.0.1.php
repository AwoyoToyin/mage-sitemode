<?php

$templates = array(
    array(
        'title' => 'Maintenance Layout 1',
        'content' => "
<div class=\"col-md-offset-2 col-md-8\">
    <div class=\"page-title\"><h1>We're Under Maintenance</h1></div>
    <p>Our store is currently undergoing a brief bit of maintenance.</p>
    <p>We apologize for any inconvenience and we're doing our best to get things <br>back to working order for you.</p>
    {{var countdown}} {{var subscribe}} {{var social}}
</div>
        ",
        'is_active' => 1,
        'stores' => array(0),
        'sort_order' => 0
    ),
    array(
        'title' => 'Maintenance Layout 2',
        'content' => "
<div class=\"col-md-offset-1 col-md-10\">
    <div class=\"page-title mb-2x\"><h1>We're Under Maintenance</h1></div>
    <div class=\"col-md-6\">
        <p>Our store is currently undergoing a brief bit of maintenance.</p>
        <p>We apologize for any inconvenience and we're doing our best to get things back to working order for you.</p>
        {{var subscribe}}
    </div>
    <div class=\"col-md-6 small\">
        {{var countdown}} {{var social}}
    </div>
</div>
        ",
        'is_active' => 1,
        'stores' => array(0),
        'sort_order' => 0
    ),
    array(
        'title' => 'Coming Soon',
        'content' => "
<div class=\"col-md-offset-2 col-md-8\">
    <div class=\"page-title\"><h1>Coming Soon</h1></div>
    <p>We're currently working on something really cool. Stay tuned!</p>
    {{var countdown}} {{var subscribe}} {{var social}}
</div>
        ",
        'is_active' => 1,
        'stores' => array(0),
        'sort_order' => 0
    )
);

/**
 * Insert default and system sitemode templates
 */
foreach ($templates as $data) {
    Mage::getModel('sitemode/template')->setData($data)->save();
}
