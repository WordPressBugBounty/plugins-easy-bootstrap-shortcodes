/**
 * Gutenberg sidebar plugin for EBS shortcode insertion.
 */
( function ( wp ) {
	'use strict';

	if ( ! wp || ! wp.plugins || ! wp.editPost || ! wp.element ) {
		return;
	}

	var createElement = wp.element.createElement;
	var Fragment = wp.element.Fragment;
	var useState = wp.element.useState;
	var registerPlugin = wp.plugins.registerPlugin;
	var PluginSidebar = wp.editPost.PluginSidebar;
	var PluginSidebarMoreMenuItem = wp.editPost.PluginSidebarMoreMenuItem;
	var PanelBody = wp.components.PanelBody;
	var Button = wp.components.Button;

	var config = window.ebsBlockEditor || {};
	var shortcodes = config.shortcodes || {};
	var groups = config.groups || {};
	var sidebarTitle = config.title || 'EBS Shortcodes';

	function groupShortcodes() {
		var grouped = {};
		Object.keys( shortcodes ).forEach( function ( key ) {
			var sc = shortcodes[ key ];
			var groupKey = sc.group || 'miscellaneous';
			if ( ! grouped[ groupKey ] ) {
				grouped[ groupKey ] = [];
			}
			grouped[ groupKey ].push( {
				key: key,
				name: sc.name || key,
				width: sc.width || 'auto',
				height: sc.height || 'auto',
			} );
		} );
		return grouped;
	}

	function ShortcodeSidebar() {
		var grouped = groupShortcodes();

		return createElement(
			Fragment,
			null,
			Object.keys( grouped ).map( function ( groupKey ) {
				var groupLabel = groups[ groupKey ] ? groups[ groupKey ].name : groupKey;
				return createElement(
					PanelBody,
					{ key: groupKey, title: groupLabel, initialOpen: groupKey === 'basic' },
					grouped[ groupKey ].map( function ( sc ) {
						return createElement(
							Button,
							{
								key: sc.key,
								variant: 'secondary',
								style: { marginBottom: '6px', width: '100%', justifyContent: 'flex-start' },
								onClick: function () {
									if ( typeof window.ebsOpenShortcodeDialog === 'function' ) {
										window.ebsOpenShortcodeDialog( sc.key, sc.width, sc.height );
									}
								},
							},
							sc.name
						);
					} )
				);
			} )
		);
	}

	function EbsSidebarPlugin() {
		return createElement(
			Fragment,
			null,
			createElement(
				PluginSidebarMoreMenuItem,
				{ target: 'ebs-shortcode-sidebar' },
				sidebarTitle
			),
			createElement(
				PluginSidebar,
				{
					name: 'ebs-shortcode-sidebar',
					title: sidebarTitle,
					icon: 'editor-kitchensink',
				},
				createElement( ShortcodeSidebar )
			)
		);
	}

	registerPlugin( 'ebs-shortcode-inserter', {
		render: EbsSidebarPlugin,
	} );
} )( window.wp );
