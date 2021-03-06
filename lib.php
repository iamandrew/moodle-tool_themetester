<?php

/**
 * Returns the HTML source generated by executing the file provided
 *
 * @param string $filename Name of the file to display
 * @return HTML source code produced by the code in $filename
 */
function tool_themetester_get_source_output($filename) {
    // we don't know what globals the file might need
    global $OUTPUT, $USER, $SESSION, $DB, $CFG;
    if (!file_exists($filename)) {
        return false;
    }
    ob_start();
    include($filename);
    return htmlentities(ob_get_clean());
}

/**
 * Returns the code contained within the file provided, escaped so
 * as to be suitable for printing to an HTML page
 *
 * @param string $filename Name of the file
 * @return Escaped copy of the code in $filename
 */
function tool_themetester_get_html_output($filename) {
    if (!file_exists($filename)) {
        return false;
    }
    return htmlentities(file_get_contents($filename));
}

function tool_themetester_get_items() {
    $contents = array(
        'Headings' => 'headings.php',
        'Common tags' => 'common.php',
        'Lists' => 'lists.php',
        'Tables' => 'tables.php',
        'Form elements' => 'forms.php',
        'Moodle form elements' => 'mform.php',
        'Moodle tab bar' => 'tabs.php',
        'Paging bar' => 'paging.php',
        'Images' => 'images.php',
        'Notifications' => 'notifications.php',
        'Progress Bars' => 'progress.php',
        'Page Layouts' => 'pagelayouts.php',
        'Bootstrap CSS' => 'bs_css.php',
        'Bootstrap Components' => 'bs_components.php',
        'Bootstrap Javascript' => 'bs_javascript.php',
        'Bootswatch Examples' => 'bootswatch.php',
    );
    return $contents;
}

function tool_themetester_add_pretend_block() {
    global $PAGE;
    $contents = tool_themetester_get_items();

    $o = html_writer::start_tag('ul');
    foreach ($contents as $title => $file) {
        $url = new moodle_url($file);
        $link = html_writer::link($url, $title);
        $o .= html_writer::tag('li', $link);
    }
    $o .= html_writer::end_tag('ul');

    $bc = new block_contents();
    $bc->title = get_string('pluginname', 'tool_themetester');
    $bc->attributes['class'] = 'block block_themetester';
    $bc->content = $o;

    $defaultregion = $PAGE->blocks->get_default_region();
    $PAGE->blocks->add_fake_block($bc, $defaultregion);
}
