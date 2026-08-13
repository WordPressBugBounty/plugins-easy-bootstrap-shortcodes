/**
 * Bridge shortcode insertion between Classic Editor (TinyMCE) and Gutenberg.
 */
( function () {
	'use strict';

	/**
	 * Insert shortcode text into the active editor.
	 *
	 * @param {string} shortcode Shortcode string to insert.
	 */
	window.ebsInsertShortcode = function ( shortcode ) {
		if (
			window.wp &&
			window.wp.data &&
			typeof window.wp.data.select === 'function' &&
			typeof window.wp.data.dispatch === 'function' &&
			window.wp.blocks &&
			typeof window.wp.blocks.createBlock === 'function'
		) {
			var blocksSelect = window.wp.data.select( 'core/blocks' );
			var blockEditorSelect = window.wp.data.select( 'core/block-editor' );
			var blockEditorDispatch = window.wp.data.dispatch( 'core/block-editor' );

			// Only insert via Gutenberg when block stores are ready. Calling
			// createBlock before core/blocks is registered causes infinite recursion.
			if (
				blocksSelect &&
				blockEditorSelect &&
				blockEditorDispatch &&
				typeof blocksSelect.getBlockType === 'function' &&
				blocksSelect.getBlockType( 'core/shortcode' )
			) {
				var block = window.wp.blocks.createBlock( 'core/shortcode', {
					text: shortcode,
				} );
				var selected = blockEditorSelect.getSelectedBlockClientId();

				if ( selected ) {
					var index = blockEditorSelect.getBlockIndex( selected );
					blockEditorDispatch.insertBlocks( block, index + 1 );
				} else {
					blockEditorDispatch.insertBlocks( block );
				}
				return;
			}
		}

		if ( typeof tinyMCE !== 'undefined' && tinyMCE.activeEditor && ! tinyMCE.activeEditor.isHidden() ) {
			tinyMCE.activeEditor.execCommand( 'mceInsertContent', false, shortcode );
		}
	};

	/**
	 * Open a shortcode popup by plugin name (used from Gutenberg sidebar).
	 *
	 * @param {string} pluginName Shortcode directory/plugin name.
	 * @param {number|string} width Popup width.
	 * @param {number|string} height Popup height.
	 */
	window.ebsOpenShortcodeDialog = function ( pluginName, width, height ) {
		var capitalized = pluginName.charAt( 0 ).toUpperCase() + pluginName.slice( 1 );
		var globalName = pluginName;
		var pluginObj = window[ globalName ];

		if ( ! pluginObj && window[ 'oscitas' + capitalized ] ) {
			pluginObj = window[ 'oscitas' + capitalized ];
		}

		if ( ! pluginObj ) {
			pluginObj = {
				title: pluginName,
				id: 'oscitas-form-' + pluginName,
				pluginName: pluginName,
			};
		}

		if ( typeof open_dialogue === 'function' ) {
			open_dialogue( pluginObj, width || 'auto', height || 'auto' );
		}
	};
} )();
