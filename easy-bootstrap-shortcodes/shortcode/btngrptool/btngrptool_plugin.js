var btngrptool={
    title:"Button Group Toolbar Shortcode"
};

(function() {
    if ( typeof tinymce === 'undefined' || ! tinymce.create ) {
        return;
    }
    tinymce.create('tinymce.plugins.oscitasBtngrptool', {
        init : function(ed, url) {
            ed.addButton('oscitasbtngrptool', {
                title : btngrptool.title,
                image : url+'/icon.png',
                onclick : function() {
                    ebsInsertShortcode('['+$ebs_prefix+'btngrptoolbar class="yourcustomclass"][/'+$ebs_prefix+'btngrptoolbar]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            plugininfo.longname=btngrptool.title;
            return plugininfo;
        }
    });
    tinymce.PluginManager.add('oscitasbtngrptool', tinymce.plugins.oscitasBtngrptool);
})();
