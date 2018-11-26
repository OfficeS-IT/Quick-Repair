jQuery(function()
	{
		(function( blocks, element ) {
            var el = wp.element.createElement,
                source 		= blocks.source,
	            InspectorControls = wp.editor.InspectorControls,
				category 	= {slug:'appointment-hour-booking', title : 'Appointment Hour Booking'};

			/* Plugin Category */
			blocks.getCategories().push({slug: 'cpapphourbk', title: 'Appointment Hour Booking'}) ;

			

			/* Form's shortcode */
			blocks.registerBlockType( 'cpapphourbk/form-shortcode', {
                title: 'Appointment Hour Booking', 
                icon: 'calendar-alt',    
                category: 'cpapphourbk',
				supports: {
					customClassName: false,
					className: false
				},
				attributes: {
					shortcode : {
						type : 'string',
						source : 'text',
						default: '[CP_APP_HOUR_BOOKING id="1"]'
					}
				},

				edit: function( props ) {
					var focus = props.isSelected;
					return [
						!!focus && el(
							InspectorControls,
							{
								key: 'cpapphourbk_inspector'
							},
							[
								el(
									'span',
									{
										key: 'cpapphourbk_inspector_help',
										style:{fontStyle: 'italic'}
									},
									'If you need help: '
								),
								el(
									'a',
									{
										key		: 'cpapphourbk_inspector_help_link',
										href	: 'https://apphourbooking.dwbooster.com/contact-us',
										target	: '_blank'
									},
									'CLICK HERE'
								)
							]
						),
						el('textarea',
							{
								key: 'cpapphourbk_form_shortcode',
								value: props.attributes.shortcode,
								onChange: function(evt){
									props.setAttributes({shortcode: evt.target.value});
								},
								style: {width:"100%", resize: "vertical"}
							}
						)
					];
				},

				save: function( props ) {
					return props.attributes.shortcode;
				}
			});

		} )(
			window.wp.blocks,
			window.wp.element
		);
	}
);