<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Main block code
 *
 * @package    block
 * @subpackage section
 * @copyright  2013 onwards Nathan Robbins (https://github.com/nrobbins)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

class block_section extends block_list {
    private $section;

    public function init() {
        $this->title = get_string('pluginname', 'block_section');
    }
    public function specialization() {
        if (!empty($this->config->title)) {
            $this->title = $this->config->title;
        } else {
            $this->title = get_string('blocktitle', 'block_section');
        }
        if (empty($this->config->section)) {
            $this->section = 0;
        } else {
            $this->section = $this->config->section;
        }
    }

    public function applicable_formats() {
        return [
                'course-view' => true,
                'site-index' => true,
                'my' => true
               ];
    }
    public function instance_allow_multiple() {
        return true;
    }

    public function get_content() {
        global $CFG, $DB;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->items = [];
        $this->content->icons = [];
        $this->content->footer = '';

        if (empty($this->instance)) {
            return $this->content;
        }

        if (!empty($this->config->course) && ($DB->get_record('course', ['id' => $this->config->course]) != null)) {
            $course = $DB->get_record('course', ['id' => $this->config->course]);
        } else {
            $course = $this->page->course;
        }

        require_once($CFG->dirroot.'/course/lib.php');

        $modinfo = get_fast_modinfo($course);
        if (!empty($modinfo->sections[$this->section])) {
            foreach ($modinfo->sections[$this->section] as $cmid) {
                $cm = $modinfo->cms[$cmid];
                if (!$cm->uservisible) {
                    continue;
                }

                $cminfo = \cm_info::create($cm);

                if (!($url = $cm->url)) {
                    if ($this->page->user_is_editing()) {
                        // Only show activity name when it is on edit mode
                        $this->content->items[] = $cminfo->get_formatted_name();
                    } else {
                        // Normal view
                        $this->content->items[] = $cminfo->get_formatted_content();
                    }
                    $this->content->icons[] = '';
                } else {
                    $linkcss = $cm->visible ? '' : ' class="dimmed" ';
                    // Accessibility: incidental image – should be empty alt text.
                    $icon = '<img src="' . $cm->get_icon_url() . '" class="icon" alt="" />&nbsp;';
                    $this->content->items[] = '<a title="'.$cm->modplural.'" '.$linkcss.' '.
                            ' href="' . $url . '">' . $icon . $cminfo->get_formatted_name() . '</a>';
                }
            }
        }
        return $this->content;
    }
}
