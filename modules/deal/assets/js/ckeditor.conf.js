CKEDITOR.editorConfig = function( config ) {
	 config.toolbar = [ 
     ['Source', '-', 'Templates'],
     ['PasteText', 'PasteFromWord', 'Find', 'Replace'],
     ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'],
     ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', '-', 'Link', 'Unlink' ],
     ['Image', 'Table', 'HorizontalRule' ],
     '/',
     [/*'Styles',*/ 'Format', 'Font', 'FontSize'],
     [ 'TextColor', 'BGColor' ],
     [ 'Maximize', 'ShowBlocks' ]
   ];
};
