
CKEDITOR.replace( 'addStudyProgEditor', {
    on: {
        instanceReady: function( ev ) {
            this.dataProcessor.writer.setRules( 'p', {
                indent: false,
                breakBeforeOpen: false,
                breakAfterOpen: false,
                breakBeforeClose: false,
                breakAfterClose: false
            });
        }
    }
} );

CKEDITOR.replace( 'modifyStudyProgEditor', {
    on: {
        instanceReady: function( ev ) {
            this.dataProcessor.writer.setRules( 'p', {
                indent: false,
                breakBeforeOpen: false,
                breakAfterOpen: false,
                breakBeforeClose: false,
                breakAfterClose: false
            });
        }
    }
} );

CKEDITOR.replace( 'addClanokEditor', {
    on: {
        instanceReady: function( ev ) {
            this.dataProcessor.writer.setRules( 'p', {
                indent: false,
                breakBeforeOpen: false,
                breakAfterOpen: false,
                breakBeforeClose: false,
                breakAfterClose: false
            });
        }
    }
} );

CKEDITOR.replace( 'modClanokEditor', {
    on: {
        instanceReady: function( ev ) {
            this.dataProcessor.writer.setRules( 'p', {
                indent: false,
                breakBeforeOpen: false,
                breakAfterOpen: false,
                breakBeforeClose: false,
                breakAfterClose: false
            });
        }
    }
} );