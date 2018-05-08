<?php

/*-----------------------------------------------------------------------------------*/
/* Alert
/*-----------------------------------------------------------------------------------*/
$minti_shortcodes['minti_alert'] = array(
	'no_preview' => true,
	'params' => array(
		'type' => array(
			'type' 		=> 'select',
			'label' 	=> __('Alert Type', 'minti-framework'),
			'desc' 		=> __('Select Alert Type', 'minti-framework'),
			'options' 	=> array(
				'warning' 	=> 'warning',
				'success' 	=> 'success',
				'error' 	=> 'error',
				'info' 		=> 'info',
			)
		),
		'content' => array(
			'std' => 'Alert Message',
			'type' => 'textarea',
			'label' => __('Alert Text', 'minti-framework'),
			'desc' => __('Alert Text', 'minti-framework'),
		),
		'close' => array(
			'type' 		=> 'select',
			'label' 	=> __('Closable', 'minti-framework'),
			'desc' 		=> __('Select if alert can be closed or not', 'minti-framework'),
			'options' 	=> array(
				'true' 		=> 'true',
				'false' 	=> 'false',
			)
		),
		
	),
	'shortcode' => '[minti_alert type="{{type}}" close="{{close}}"]{{content}}[/minti_alert]',
	'popup_title' => __('Insert Alert Shortcode', 'minti-framework')
);

/*-----------------------------------------------------------------------------------*/
/* Blockquote
/*-----------------------------------------------------------------------------------*/
$minti_shortcodes['minti_blockquote'] = array(
	'no_preview' => true,
	'params' => array(
		'content' => array(
			'std' => 'Blockquote Text',
			'type' => 'textarea',
			'label' => __('Blockquote Text', 'minti-framework'),
			'desc' => '',
		),
	),
	'shortcode' => '[minti_blockquote]{{content}}[/minti_blockquote]',
	'popup_title' => __('Insert Blockquote Shortcode', 'minti-framework')
);

/*-----------------------------------------------------------------------------------*/
/* Button
/*-----------------------------------------------------------------------------------*/
$minti_shortcodes['minti_button'] = array(
	'no_preview' => true,
	'params' => array(
		'content' => array(
			'std' => 'Click Me',
			'type' => 'text',
			'label' => __('Button Text', 'minti-framework'),
			'desc' => __('Button Text', 'minti-framework'),
		),
		'link' => array(
			'std' => 'http://example.com',
			'type' => 'text',
			'label' => __('Link', 'minti-framework'),
			'desc' => __('Link of the button', 'minti-framework'),
		),
		'size' => array(
			'type' => 'select',
			'label' => __('Size', 'minti-framework'),
			'desc' => '',
			'options' => array(
				'small' => 'small',
				'medium' => 'medium',
				'large' => 'large',
				'full' => 'full'
			)
		),
		'target' => array(
			'type' => 'select',
			'label' => __('Target', 'minti-framework'),
			'desc' => 'Target of the Link',
			'options' => array(
				'_self' => 'Open in same Window',
				'_blank' => 'Open in new Window'
			)
		),
		'lightbox' => array(
			'type' => 'select',
			'label' => __('Open in Lightbox?', 'minti-framework'),
			'desc' => 'Open Link in Lightbox? Only use when link is an image',
			'options' => array(
				'false' => 'No',
				'true' => 'Yes'
			)
		),
		'color' => array(
			'type' => 'select',
			'label' => __('Color', 'minti-framework'),
			'desc' => 'Button Color',
			'options' => array(
				'color-1' => 'color-1',
				'color-2' => 'color-2',
				'color-3' => 'color-3',
				'color-4' => 'color-4',
				'color-5' => 'color-5',
				'color-6' => 'color-6',
				'color-7' => 'color-7',
				'color-8' => 'color-8',
				'color-9' => 'color-9',
				'yellow' => 'yellow',
				'orange' => 'orange',
				'red' => 'red',
				'blue' => 'blue',
				'green' => 'green'
			)
		),
		'icon' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Icon', 'minti-framework'),
			'desc' => __('Can be any Fontawesome Icon (ie. fa-phone) - or leave it blank', 'minti-framework'),
		),
	),
	'shortcode' => '[minti_button link="{{link}}" size="{{size}}" target="{{target}}" lightbox="{{lightbox}}" color="{{color}}" icon="{{icon}}"]{{content}}[/minti_button]',
	'popup_title' => __('Insert Button Shortcode', 'minti-framework')
);

/*-----------------------------------------------------------------------------------*/
/* Center
/*-----------------------------------------------------------------------------------*/
$minti_shortcodes['minti_center'] = array(
	'no_preview' => true,
	'params' => array(
		'content' => array(
			'std' => 'Center Text',
			'type' => 'textarea',
			'label' => __('Center Text', 'minti-framework'),
			'desc' => '',
		),
	),
	'shortcode' => '[minti_center]{{content}}[/minti_center]',
	'popup_title' => __('Insert Center Shortcode', 'minti-framework')
);

/*-----------------------------------------------------------------------------------*/
/* Counter
/*-----------------------------------------------------------------------------------*/
$minti_shortcodes['minti_counter'] = array(
	'no_preview' => true,
	'params' => array(
		'number' => array(
			'std' => '197',
			'type' => 'text',
			'label' => __('Number', 'minti-framework'),
			'desc' => '',
		),
		'title' => array(
			'std' => 'Cups of Coffee',
			'type' => 'text',
			'label' => __('Title', 'minti-framework'),
			'desc' => 'Title of the Count Number',
		),
		'color' => array(
			'std' => '#666666',
			'type' => 'text',
			'label' => __('Color', 'minti-framework'),
			'desc' => 'Hex Color of the Number',
		),
	),
	'shortcode' => '[minti_counter number="{{number}}" title="{{title}}" color="{{color}}"]',
	'popup_title' => __('Insert Counter Shortcode', 'minti-framework')
);

/*-----------------------------------------------------------------------------------*/
/* Dropcap
/*-----------------------------------------------------------------------------------*/
$minti_shortcodes['minti_dropcap'] = array(
	'no_preview' => true,
	'params' => array(
		'content' => array(
			'std' => 'R',
			'type' => 'text',
			'label' => __('Sign', 'minti-framework'),
			'desc' => 'Dropcap Sign',
		),
		'style' => array(
			'type' => 'select',
			'label' => __('Dropcap Style', 'minti-framework'),
			'desc' => '',
			'options' => array(
				'normal' => 'Normal',
				'circle' => 'Circle',
				'box' => 'Box',
				'book' => 'Book',
				'color' => 'Color',
			)
		),
	),
	'shortcode' => '[minti_dropcap style="{{style}}"]{{content}}[/minti_dropcap]',
	'popup_title' => __('Insert Dropcap Shortcode', 'minti-framework')
);

/*-----------------------------------------------------------------------------------*/
/* Google Font
/*-----------------------------------------------------------------------------------*/
$minti_shortcodes['minti_googlefont'] = array(
	'no_preview' => true,
	'params' => array(
		'content' => array(
			'std' => 'Your Content',
			'type' => 'textarea',
			'label' => __('Text', 'minti-framework'),
			'desc' => 'Insert your Text',
		),
		'font' => array(
			'std' => 'Swanky and Moo Moo',
			'type' => 'text',
			'label' => __('Font', 'minti-framework'),
			'desc' => 'Font Name from the <a href="https://www.google.com/fonts" target="_blank">Google Font Directory</a>',
		),
		'size' => array(
			'std' => '42px',
			'type' => 'text',
			'label' => __('Font Size', 'minti-framework'),
			'desc' => 'Set your Font Size in px',
		),
		'margin' => array(
			'std' => '0px 0px 20px 0px',
			'type' => 'text',
			'label' => __('Margin', 'minti-framework'),
			'desc' => 'Margin - topmargin rightmargin bottommargin leftmargin',
		),
	),
	'shortcode' => '[minti_googlefont font="{{font}}" size="{{size}}" margin="{{margin}}"]{{content}}[/minti_googlefont]',
	'popup_title' => __('Insert Google Font Shortcode', 'minti-framework')
);

/*-----------------------------------------------------------------------------------*/
/* Divider
/*-----------------------------------------------------------------------------------*/
$minti_shortcodes['minti_divider'] = array(
	'no_preview' => true,
	'params' => array(
		'style' => array(
			'std' => '1',
			'type' => 'select',
			'label' => __('Style', 'minti-framework'),
			'desc' => 'Divider Style',
			'options' => array(
				'1' => 'Thin Light Grey',
				'2' => 'Dotted',
				'3' => 'Line with Shadow',
				'4' => 'Diagonal Lines',
				'5' => 'Short Accent Color',
				'6' => 'Short Light Grey',
				'7' => 'Dashed Line',
				'8' => 'Centered Line with Icon',
				'9' => 'Thin Light for Dark backgrounds',
			)
		),
		'icon' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Icon', 'minti-framework'),
			'desc' => __('Only fill out for "Centered Line with Icon"-Style. Can be any Fontawesome Icon (ie. fa-phone)', 'minti-framework'),
		),
		'margin' => array(
			'std' => '60px 0px 60px 0px',
			'type' => 'text',
			'label' => __('Margin', 'minti-framework'),
			'desc' => 'Margin - topmargin rightmargin bottommargin leftmargin',
		),
	),
	'shortcode' => '[minti_divider style="{{style}}" icon="{{icon}}" margin="{{margin}}"]',
	'popup_title' => __('Insert Divider Shortcode', 'minti-framework')
);

/*-----------------------------------------------------------------------------------*/
/* Icon
/*-----------------------------------------------------------------------------------*/
$minti_shortcodes['minti_icon'] = array(
	'no_preview' => true,
	'params' => array(
		'icon' => array(
			'std' => 'fa-phone',
			'type' => 'text',
			'label' => __('Icon', 'minti-framework'),
			'desc' => __('Can be any Fontawesome or SimpleLine Icons (ie. fa-phone)', 'minti-framework'),
		),
		'size' => array(
			'type' => 'text',
			'label' => __('Size', 'minti-framework'),
			'desc' => 'Size of the icon',
			'std' => '14px',
		),
		'color' => array(
			'std' => '#888888',
			'type' => 'text',
			'label' => __('Color', 'minti-framework'),
			'desc' => 'Icon Color',
		),
		'margin' => array(
			'std' => '0px 0px 0px 0px',
			'type' => 'text',
			'label' => __('Margin', 'minti-framework'),
			'desc' => 'Margin - topmargin rightmargin bottommargin leftmargin',
		),
	),
	'shortcode' => '[minti_icon icon="{{icon}}" color="{{color}}" size="{{size}}" margin="{{margin}}"]',
	'popup_title' => __('Insert Icon Shortcode', 'minti-framework')
);

/*-----------------------------------------------------------------------------------*/
/* List
/*-----------------------------------------------------------------------------------*/
$minti_shortcodes['minti_list'] = array(
	'params' => array(),
    'no_preview' => true,
    'shortcode' => '[minti_list]{{child_shortcode}}[/minti_list]',
    'popup_title' => __('Insert List Shortcode', 'minti-framework'),
    
    'child_shortcode' => array(
        'params' => array(
            'icon' => array(
                'std' => 'fa-check',
                'type' => 'text',
                'label' => __('Icon', 'minti-framework'),
                'desc' => __('Insert any of the Fontawesome Icons', 'minti-framework'),
            ),
            'content' => array(
                'std' => 'Bullet Point Content',
                'type' => 'textarea',
                'label' => __('List Content', 'minti-framework'),
                'desc' => __('Add list content', 'minti-framework')
            )
        ),
        'shortcode' => '[minti_listitem icon="{{icon}}"]{{content}}[/minti_listitem]',
        'clone_button' => __('Add List Item', 'minti-framework')
    )
);

/*-----------------------------------------------------------------------------------*/
/* Progressbar
/*-----------------------------------------------------------------------------------*/
$minti_shortcodes['minti_progressbar'] = array(
	'no_preview' => true,
	'params' => array(
		'percentage' => array(
			'std' => '90',
			'type' => 'text',
			'label' => __('Percentage', 'minti-framework'),
			'desc' => 'Percentage 0-100',
		),
		'title' => array(
			'std' => 'Photoshop Skills',
			'type' => 'text',
			'label' => __('Title', 'minti-framework'),
			'desc' => 'Title of the Progressbar',
		),
		'color' => array(
			'std' => '#999999',
			'type' => 'text',
			'label' => __('Color', 'minti-framework'),
			'desc' => 'Color of the Progressbar',
		),
	),
	'shortcode' => '[minti_progressbar percentage="{{percentage}}" title="{{title}}" color="{{color}}"]',
	'popup_title' => __('Insert Progressbar Shortcode', 'minti-framework')
);

/*-----------------------------------------------------------------------------------*/
/* Pullquote
/*-----------------------------------------------------------------------------------*/
$minti_shortcodes['minti_pullquote'] = array(
	'no_preview' => true,
	'params' => array(
		'content' => array(
			'std' => 'Pullquote Text',
			'type' => 'textarea',
			'label' => __('Pullquote Text', 'minti-framework'),
			'desc' => '',
		),
		'align' => array(
			'type' => 'select',
			'label' => __('Align', 'minti-framework'),
			'desc' => '',
			'options' => array(
				'left' => 'left',
				'right' => 'right'
			)
		),
	),
	'shortcode' => '[minti_pullquote align="{{align}}"]{{content}}[/minti_pullquote]',
	'popup_title' => __('Insert Pullquote Shortcode', 'minti-framework')
);

/*-----------------------------------------------------------------------------------*/
/* Social
/*-----------------------------------------------------------------------------------*/
$minti_shortcodes['minti_social'] = array(
	'no_preview' => true,
	'params' => array(
		'icon' => array(
			'std' => '3',
			'type' => 'select',
			'label' => __('Icon', 'minti-framework'),
			'desc' => '',
			'options' => array(
				'fa-android' => 'Android',
				'fa-apple' => 'Apple',
				'fa-behance' => 'Behance',
				'fa-bitcoin' => 'Bitcoin',
				'fa-codepen' => 'Codepen',
				'fa-css3' => 'CSS3',
				'fa-delicious' => 'Delicious',
				'fa-deviantart' => 'Deviantart',
				'fa-digg' => 'Digg',
				'fa-dribbble' => 'Dribbble',
				'fa-dropbox' => 'Dropbox',
				'fa-drupal' => 'Drupal',
				'fa-empire' => 'Empire',
				'fa-envelope-o' => 'E-Mail',
				'fa-facebook' => 'Facebook',
				'fa-flickr' => 'Flickr',
				'fa-foursquare' => 'Foursquare',
				'fa-github-alt' => 'Github',
				'fa-google' => 'Google',
				'fa-google-plus' => 'Google-Plus',
				'fa-html5' => 'HTML5',
				'fa-instagram' => 'Instagram',
				'fa-joomla' => 'Joomla',
				'fa-linkedin' => 'Linkedin',
				'fa-openid' => 'OpenID',
				'fa-pagelines' => 'Pagelines',
				'fa-pinterest' => 'Pinterest',
				'fa-reddit' => 'Reddit',
				'fa-renren' => 'Renren',
				'fa-skype' => 'Skype',
				'fa-soundcloud' => 'Soundcloud',
				'fa-spotify' => 'Spotify',
				'fa-stack-overflow' => 'Stack Overflow',
				'fa-steam' => 'Steam',
				'fa-stumbleupon' => 'StumbleUpon',
				'fa-weibo' => 'Weibo',
				'fa-trello' => 'Trello',
				'fa-tumblr' => 'Tumblr',
				'fa-twitter' => 'Twitter',
				'fa-vimeo-square' => 'Vimeo',
				'fa-vine' => 'Vine',
				'fa-vk' => 'VK',
				'fa-xing' => 'Xing',
				'fa-yahoo' => 'Yahoo',
				'fa-wordpress' => 'WordPress',
				'fa-youtube-play' => 'YouTube',
			)
		),
		'url' => array(
			'std' => 'http://',
			'type' => 'text',
			'label' => __('URL', 'minti-framework'),
			'desc' => __('Link of the Social Icon', 'minti-framework'),
		),
		'target' => array(
			'type' => 'select',
			'label' => __('Target', 'minti-framework'),
			'desc' => 'Target of the Link',
			'options' => array(
				'_self' => 'Open in same Window',
				'_blank' => 'Open in new Window'
			)
		),
	),
	'shortcode' => '[minti_social icon="{{icon}}" url="{{url}}" target="{{target}}"]',
	'popup_title' => __('Insert Social Icon Shortcode', 'minti-framework')
);

/*-----------------------------------------------------------------------------------*/
/* Spacer
/*-----------------------------------------------------------------------------------*/
$minti_shortcodes['minti_spacer'] = array(
	'no_preview' => true,
	'params' => array(
		'height' => array(
			'std' => '40',
			'type' => 'text',
			'label' => __('Height', 'minti-framework'),
			'desc' => 'Height in px (leave the "px" out)',
		)
	),
	'shortcode' => '[minti_spacer height="{{height}}"]',
	'popup_title' => __('Insert Spacer Shortcode', 'minti-framework')
);

/*-----------------------------------------------------------------------------------*/
/* Testimonial
/*-----------------------------------------------------------------------------------*/
$minti_shortcodes['minti_testimonial'] = array(
	'no_preview' => true,
	'params' => array(
		'author' => array(
			'std' => 'John Doe',
			'type' => 'text',
			'label' => __('Author', 'minti-framework'),
			'desc' => __('Author of the Testimonial', 'minti-framework'),
		),
		'content' => array(
			'std' => 'Your Content',
			'type' => 'textarea',
			'label' => __('Text', 'minti-framework'),
			'desc' => 'Insert your Text',
		),
	),
	'shortcode' => '[minti_testimonial author="{{author}}"]{{content}}[/minti_testimonial]',
	'popup_title' => __('Insert Testimonial Shortcode', 'minti-framework')
);

/*-----------------------------------------------------------------------------------*/
/* Text
/*-----------------------------------------------------------------------------------*/
$minti_shortcodes['minti_text'] = array(
	'no_preview' => true,
	'params' => array(
		'content' => array(
			'std' => 'Your Content',
			'type' => 'textarea',
			'label' => __('Text', 'minti-framework'),
			'desc' => 'Insert your Text',
		),
		'size' => array(
			'std' => '28px',
			'type' => 'text',
			'label' => __('Font Size', 'minti-framework'),
			'desc' => __('Size of the Text', 'minti-framework'),
		),
		'color' => array(
			'std' => '#666666',
			'type' => 'text',
			'label' => __('Color', 'minti-framework'),
			'desc' => __('Color of the Text', 'minti-framework'),
		),
		'align' => array(
			'type' => 'select',
			'label' => __('Align', 'minti-framework'),
			'desc' => 'Text Align',
			'options' => array(
				'center' => 'center',
				'left' => 'left',
				'right' => 'right',
			)
		),
		'weight' => array(
			'type' => 'select',
			'label' => __('Weight', 'minti-framework'),
			'desc' => 'Weight of the Text (if available for the font).',
			'options' => array(
				'normal' => 'normal',
				'bold' => 'bold',
				'100' => '100',
				'200' => '200',
				'300' => '300',
				'400' => '400',
				'500' => '500',
				'600' => '600',
				'700' => '700',
			)
		),
		'margin' => array(
			'std' => '0px 0px 20px 0px',
			'type' => 'text',
			'label' => __('Margin', 'minti-framework'),
			'desc' => 'Margin - topmargin rightmargin bottommargin leftmargin',
		),
	),
	'shortcode' => '[minti_text size="{{size}}" color="{{color}}" align="{{align}}" weight="{{weight}}" margin="{{margin}}"]{{content}}[/minti_text]',
	'popup_title' => __('Insert Text Shortcode', 'minti-framework')
);

/*-----------------------------------------------------------------------------------*/
/* Title
/*-----------------------------------------------------------------------------------*/
$minti_shortcodes['minti_title'] = array(
	'no_preview' => true,
	'params' => array(
		'content' => array(
			'std' => 'Your Title',
			'type' => 'textarea',
			'label' => __('Text', 'minti-framework'),
			'desc' => 'Insert your Title',
		),
		'align' => array(
			'type' => 'select',
			'label' => __('Align', 'minti-framework'),
			'desc' => 'Text Align',
			'options' => array(
				'center' => 'center',
				'left' => 'left',
			)
		),
		'margin' => array(
			'std' => '0px 0px 20px 0px',
			'type' => 'text',
			'label' => __('Margin', 'minti-framework'),
			'desc' => 'Margin - topmargin rightmargin bottommargin leftmargin',
		),
	),
	'shortcode' => '[minti_title align="{{align}}" margin="{{margin}}"]{{content}}[/minti_title]',
	'popup_title' => __('Insert Title Shortcode', 'minti-framework')
);

/*-----------------------------------------------------------------------------------*/
/* Tooltip
/*-----------------------------------------------------------------------------------*/
$minti_shortcodes['minti_tooltip'] = array(
	'no_preview' => true,
	'params' => array(
		'text' => array(
			'std' => 'I am a Tooltip',
			'type' => 'text',
			'label' => __('Tooltip Text', 'minti-framework'),
			'desc' => __('Text of the Tooltip', 'minti-framework'),
		),
		'content' => array(
			'std' => 'This text has a tooltip',
			'type' => 'textarea',
			'label' => __('Text', 'minti-framework'),
			'desc' => '',
		),
	),
	'shortcode' => '[minti_tooltip text="{{text}}"]{{content}}[/minti_tooltip]',
	'popup_title' => __('Insert Tooltip Shortcode', 'minti-framework')
);

/*-----------------------------------------------------------------------------------*/
/* Visibility
/*-----------------------------------------------------------------------------------*/
$minti_shortcodes['minti_visibility'] = array(
	'no_preview' => true,
	'params' => array(
		'show' => array(
			'type' => 'select',
			'label' => __('Show', 'minti-framework'),
			'desc' => 'Show an element according to the size of the Browser',
			'options' => array(
				'desktop' => 'Desktop',
				'tablet' => 'Tablet',
				'mobile' => 'Mobile',
				'mobile-portrait' => 'Mobile Portrait',
				'mobile-landscape' => 'Mobile Landscape',
			)
		),
		'content' => array(
			'std' => 'Your Content',
			'type' => 'textarea',
			'label' => __('Content', 'minti-framework'),
			'desc' => '',
		),
	),
	'shortcode' => '[minti_visibility show="{{show}}"]{{content}}[/minti_visibility]',
	'popup_title' => __('Insert Visibility Shortcode', 'minti-framework')
);

?>