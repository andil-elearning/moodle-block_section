﻿<?php
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
 * Edit form
 *
 * @package    block
 * @subpackage section
 * @copyright  2012 onwards Nathan Robbins
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_section_edit_form extends block_edit_form {
 
    protected function specific_definition($mform) {
        $context = $this->page->context;
        // Section header title according to language file.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block_section'));

        // Give the block a title
		$mform->addElement('text', 'config_title', get_string('blocktitle', 'block_section'));
		$mform->setDefault('config_title', get_string('blocktitle', 'block_section'));
		$mform->setType('config_title', PARAM_MULTILANG);
        
        // Allow teachers to edit the block instance
        //if (has_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM))) {
        //$mform->addElement('selectyesno', 'config_teacheredit', get_string('blockteacheredit', 'block_section'));
        //$mform->setDefault('config_teacheredit', 1);
        //}
        
        //Select the course id if admin
        if (has_capability('block/section:editcourses', context_course::instance($this->page->course->id))) {
        $mform->addElement('text', 'config_course', get_string('blockcourse', 'block_section'));
        $mform->setDefault('config_course', $this->page->course->id);
        $mform->setType('config_course', PARAM_INTEGER);
        }

        // Select the section to display
        if (has_capability('block/section:editsections', context_course::instance($this->page->course->id))) {
        $mform->addElement('text', 'config_section', get_string('blockstring', 'block_section'));
        $mform->setDefault('config_section', 0);
        $mform->setType('config_section', PARAM_INTEGER);  
        } 
    }
}