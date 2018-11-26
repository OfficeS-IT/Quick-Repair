( function( api ) {

	// Extends our custom "vw-automobile-lite" section.
	api.sectionConstructor['vw-automobile-lite'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );