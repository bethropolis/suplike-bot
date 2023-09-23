<?php
/**
 * Returns the content header based on the DEBUG_ENABLED flag.
 *
 * @throws Some_Exception_Class description of exception
 * @return string The content header ('application/json' if DEBUG_ENABLED is true, 'text/html' otherwise)
 */
function load_content_header(): string
{ 
    if (DEBUG_ENABLED) {
        return 'application/json';
    } else {
        return 'text/html';
    }
}

/**
 * Sets the content type header.
 *
 * @throws void
 * @return void
 */
function set_content_type_header(): void
{
    header('Content-Type: ' . load_content_header());
}

set_content_type_header();