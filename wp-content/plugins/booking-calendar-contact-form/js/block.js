jQuery(function()
	{
		(function( blocks, element ) {
            var el = wp.element.createElement,
                source 		= blocks.source,
	            InspectorControls = wp.editor.InspectorControls,
				category 	= {slug:'booking-calendar-contact-form', title : 'Booking Calendar Contact Form'};

			/* Plugin Category */
			blocks.getCategories().push({slug: 'cpbccf', title: 'Booking Calendar Contact Form'}) ;

			
            /* ICONS */
   	        const iconCPBCCF = el('img', { width: 20, height: 20, src:  "data:image/gif;base64,R0lGODlhFAATAPcAAP//////AP8A//8AAAD//wD/AAAA/wAAAK8CA6sJCrkgIakmJ8R7fM+MjdGcnc6jpMmDhcqgocWcnejIyeHLzPTo6rSxs//+/4WEhfXy9vXw+O7r8cbEyNDP0c3Mzr28wZaVm6urrKOjpJSUlVNXWBccHWtvb4eJidze3vP09MTFxb2+vkFEQ05TUfv+/LzgvszizE9RT5WXlUdIR+3u7dPU087Pzs3OzaWmpZaXlhSZBU60QXfFakqeO2qqXqzao9bn093w2TiwFzuzGmG2S2m/Um7CWDevFTuxGUWwJEuwK0yuLZfUhcXnu1mtO2TFPUy/HWPGN3nJWLPjnqivpWPIMGbLM2HDM2nMN72/vK6wrWTJMGjLNZTWcanWktb3xHXSPHrTRobWV2mHV6W1nGSmOG18Y+b62e7556KkoN7f3b6/vba3tausqvn79svMyZOhUH+DN4aGg5ubmJycmoqKiIKCgMvLybS0srKysHh4d/39/NnZ2MLCwaGhoJubmpOTkpCQj5KKabqLbff088SCe9m+u+fe3YBnZc7CweLV1LlsarB+fM6mpe7W1Z0AAK8BAZcEA7ULC6sLC7QPD6cYFqcdHagiIrM4N7pAP7E+PrRISLBRULRXVrNubc1+fsd9fcF9fb58fMOBgMmGhtSQkMOGhtiWltKYl9Wenc+cm+Kurdaqqd2xsd+7u9a0tNy+vte9verPz9nCwu7Z2fLe3t7MzO7e3unh4fny8v7+/vr6+vn5+ff39/T09PDw8O7u7u3t7erq6uXl5dzc3Nvb28PDw8HBwb+/v7q6urOzs7CwsK2traurq6mpqZ2dnZiYmIuLi4mJiX5+fn19fXp6enh4eG9vb////wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAANgALAAAAAAUABMAAAj/AAEIHEgQAAoOMF64IKgLwIUONoI0+cGExw4fFnroAFKwiRQyVJQMEXLkCJIkS8rEEVRh4AUvUJwQKRIFCxcrW6rAKeQAFYRaAjeMecLDCJErYMKI6TKIAqxPDQ45cAQggxkpXZhM+XIGjRtHD1QlkIRgky1TuXTJUSNQA4gPAGiRmlVpEqVTlxY1ogVghAcAKUiUMAFggihDCzCR6hSJUyxXAJzlAbBLxYkWeyowwmXp1ioEj0bBkgWgz5yBK1jQIISokapMCiBpUjRqD4BidQaqmVFjlwxPrF6VSmUrFFAAwOz0EugrRhuBF1gxaJUKlCJeAvfIGSZQF7RjA/fIdYogIZEy7gIB2SiYPdgdP3+OiUA2sFmy7L1+DeNzYw0ePGz0AQ0OAxnjTArCqFHDG1mwoUUadARihx7X5DAQMc8UY8MxyuCQgzTTWGPNNNE8swwxAwEDzR/SUGNNNRjkEIIxxQSzC3u6MBNIM8bwIcyN7A0UEAA7" } )       

			/* Form's shortcode */
			blocks.registerBlockType( 'cpbccf/form-shortcode', {
                title: 'Booking Calendar Contact Form', 
                icon: iconCPBCCF,    
                category: 'cpbccf',
				supports: {
					customClassName: false,
					className: false
				},
				attributes: {
					shortcode : {
						type : 'string',
						source : 'text',
						default: '[CP_BCCF_FORM]'
					}
				},

				edit: function( props ) {
					var focus = props.isSelected;
					return [
						!!focus && el(
							InspectorControls,
							{
								key: 'cpbccf_inspector'
							},
							[
								el(
									'span',
									{
										key: 'cpbccf_inspector_help',
										style:{fontStyle: 'italic'}
									},
									'If you need help: '
								),
								el(
									'a',
									{
										key		: 'cpbccf_inspector_help_link',
										href	: 'https://bccf.dwbooster.com/contact-us',
										target	: '_blank'
									},
									'CLICK HERE'
								)
							]
						),
						el('textarea',
							{
								key: 'cpbccf_form_shortcode',
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