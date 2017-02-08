/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

 CKEDITOR.editorConfig = function( config ) {
 	config.toolbarGroups = [
 		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
 		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
 		{ name: 'links', groups: [ 'links' ] },
 		{ name: 'insert', groups: [ 'insert' ] },
 		{ name: 'forms', groups: [ 'forms' ] },
 		{ name: 'tools', groups: [ 'tools' ] },
 		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
 		{ name: 'others', groups: [ 'others' ] },
 		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
 		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
 		{ name: 'styles', groups: [ 'styles' ] },
 		{ name: 'colors', groups: [ 'colors' ] },
 		{ name: 'about', groups: [ 'about' ] }
 	];

 	config.removeButtons = 'Underline,Subscript,Superscript,About,Source';
	config.mathJaxLib = '//cdn.mathjax.org/mathjax/2.6-latest/MathJax.js?config=TeX-AMS_HTML';
	config.extraPlugins = 'uploadimage';
	config.uploadUrl = './../AJAX/upload_ck_pic.php?type=json';
	config.extraPlugins = 'youtube';
	config.extraPlugins = 'filebrowser';
	config.filebrowserUploadUrl = './../AJAX/upload_ck_pic.php?type=html';
	config.extraPlugins = 'image2';
 };
