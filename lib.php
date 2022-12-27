<?php

defined('MOODLE_INTERNAL') || die();

/**
 * Returns the name of the user preferences as well as the details this plugin uses. 
 *
 * @return array
 */
function block_bcn_birthdays_section_user_preferences()
{
    $preferences = [];
    return $preferences;
}

/**
 * Invalidate all server and client side caches.
 *
 * This method deletes the physical directory that is used to cache the theme
 * files used for serving.
 * Because it deletes the main theme cache directory all themes are reset by
 * this function.
 */
function block_bcn_birthdays_section_reset_all_caches() {
   
    global $CFG, $PAGE;
    require_once("{$CFG->libdir}/filelib.php");

    $next = theme_get_next_revision();
    theme_set_revision($next);

    if (!empty($CFG->themedesignermode)) {
        $cache = cache::make_from_params(cache_store::MODE_APPLICATION, 'core', 'themedesigner');
        $cache->purge();
    }

    // Purge compiled post processed css.
    cache::make('core', 'postprocessedcss')->purge();

    // Delete all old theme localcaches.
    $themecachedirs = glob("{$CFG->localcachedir}/theme/*", GLOB_ONLYDIR);
    foreach ($themecachedirs as $localcachedir) {
        fulldelete($localcachedir);
    }

    if ($PAGE) {
        $PAGE->reload_theme();
    }
}

function block_bcn_birthdays_section_pluginfile($course, $birecord_or_cm, $context, $filearea, $args, $forcedownload, array $options = array())
{

    global $DB, $CFG, $USER;
   
    if ($context->contextlevel != CONTEXT_BLOCK) {
        send_file_not_found();
    }

    // If block is in course context, then check if user has capability to access course.
    if ($context->get_course_context(false)) {
        require_course_login($course);
    } else if ($CFG->forcelogin) {
        require_login();
    } else {
        // Get parent context and see if user have proper permission.
        $parentcontext = $context->get_parent_context();
        if ($parentcontext->contextlevel === CONTEXT_COURSECAT) {
            // Check if category is visible and user can view this category.
            if (!core_course_category::get($parentcontext->instanceid, IGNORE_MISSING)) {
                send_file_not_found();
            }
        } else if ($parentcontext->contextlevel === CONTEXT_USER && $parentcontext->instanceid != $USER->id) {
            // The block is in the context of a user, it is only visible to the user who it belongs to.
            send_file_not_found();
        }
        // At this point there is no way to check SYSTEM context, so ignoring it.
    }

    $fs = get_file_storage();

    $filename = array_pop($args);
    $filepath = $args ? '/' . implode('/', $args) . '/' : '/';
    $id = str_replace("/", "", $filepath);

    if (!$file = $fs->get_file($context->id, 'block_bcn_birthdays_section', $filearea , $id, '/', $filename) or $file->is_directory()) {
        send_file_not_found();
    }

    if ($parentcontext = context::instance_by_id($birecord_or_cm->parentcontextid, IGNORE_MISSING)) {
        if ($parentcontext->contextlevel == CONTEXT_USER) {
            // force download on all personal pages including /my/
            //because we do not have reliable way to find out from where this is used
            $forcedownload = true;
        }
    } else {
        // weird, there should be parent context, better force dowload then
        $forcedownload = true;
    }

    // NOTE: it woudl be nice to have file revisions here, for now rely on standard file lifetime,
    //       do not lower it because the files are dispalyed very often.
    \core\session\manager::write_close();
    send_stored_file($file, null, 0, $forcedownload, $options);
}
