## 3.1.1

* In edit mode, display only the name of url-less modules (labels, subsections, ...) to avoid host-page side effects. Rendering their full content via `get_formatted_content()` could trigger the host course's activity chooser init with the wrong courseid (breaking "Add activity" with a `sectionnotexist` error) or interfere with the availability dropdown menu. (PR #4, WR #463311 — thanks @waleedhassan5)

## 3.1.0

* Implements Backup / Restore. Thanks To Simon Thornett (@SimonThornett)
* Remove deprecated variable usage

## 3.0.1

* Make changes for PHP 8.2 compliance

## 3.0.0

* Make plugin works from Moodle 3.5 onwards.

## 2.4.1

* Removed edit mode - edit the content in the original course.
* Managers and Admins can add Section blocks to My Moodle
