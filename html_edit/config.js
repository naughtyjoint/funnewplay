/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

    config.uiColor = '#EFDFFF';
    config.height = 350;
    config.language = 'zh';

    config.allowedContent=true;

	    //工具列設定
	   config.toolbar = 'TadToolbar';
    config.toolbar_TadToolbar =
    [
       ['Source','-'],

       ['Maximize','Cut','Copy','Paste','PasteText','PasteFromWord'],

       ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],

       ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
        ['TextColor','BGColor','-','NumberedList','BulletedList',],
       '/',

        ['Outdent','Indent','Iineheight'],

        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],

        ['Link','Unlink','Anchor'],

       ['Image','Flash','Table','HorizontalRule','SpecialChar','PageBreak'],
       ['Format','Font','FontSize']


    ];


    config.font_names = 'Arial;Arial Black;Comic Sans MS;Courier New;Tahoma;Times New Roman;Verdana;新細明體;細明體;標楷體;微軟正黑體';
    //config.FontSize = 'Arial;Arial Black;Comic Sans MS;Courier New;Tahoma;Times New Roman;Verdana;新細明體;細明體;標楷體;微軟正黑體';
    config.fontSize_sizes ='8/8px;9/9px;10/10px;11/11px;12/12px;13/13px;14/14px;15/15px;16/16px;17/17px;18/18px;19/19px;20/20px;21/21px;22/22px;23/23px;24/24px;25/25px;26/26px;28/28px;36/36px;48/48px;72/72px'


   	//開啟圖片上傳功能
   	config.filebrowserBrowseUrl = 'html_edit_upload/ckfinder.html';
   	config.filebrowserImageBrowseUrl = 'html_edit_upload/ckfinder.html?Type=Image';
   	config.filebrowserFlashBrowseUrl = 'html_edit_upload/ckfinder.html?Type=Flash';
   	config.filebrowserUploadUrl = 'html_edit_upload/core/connector/php/connector.php?command=QuickUpload&type=Files';
   	config.filebrowserImageUploadUrl = 'html_edit_upload/core/connector/php/connector.php?command=QuickUpload&type=Image';
   	config.filebrowserFlashUploadUrl = 'html_edit_upload/core/connector/php/connector.php?command=QuickUpload&type=Flash';









};
